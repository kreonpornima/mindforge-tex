# Clean-Logs.ps1
param(
    [string]$Path = "V:\xampp\htdocs\tex\logs",
    [int]$AgeHours = 48,
    [long]$SizeThresholdBytes = 500MB,
    [string]$FilePattern = "*.log",
    [switch]$WhatIfRun
)

# Prepare logging
$cleanupDir = Join-Path $Path "cleanup"
if (-not (Test-Path $cleanupDir)) { New-Item -ItemType Directory -Path $cleanupDir | Out-Null }
$logFile = Join-Path $cleanupDir ("cleanup-{0}.clog" -f (Get-Date -Format "yyyyMMdd"))

function Write-Log($msg) {
    $timestamp = (Get-Date).ToString("yyyy-MM-dd HH:mm:ss")
    "$timestamp `t $msg" | Out-File -FilePath $logFile -Append -Encoding UTF8
}

Write-Log "----- Cleanup run started for path: $Path -----"
$cutoff = (Get-Date).AddHours(-$AgeHours)

try {
    # exclude the cleanup folder
    $files = Get-ChildItem -Path $Path -Recurse -File -Filter $FilePattern -ErrorAction Stop |
             Where-Object { $_.DirectoryName -notlike (Join-Path $Path "cleanup*") }
} catch {
    Write-Log "ERROR: Failed to enumerate files in $Path. $_"
    exit 1
}

$targets = $files | Where-Object {
    ($_.LastWriteTime -lt $cutoff) -or ($_.Length -ge $SizeThresholdBytes)
}

if (-not $targets) {
    Write-Log "No files matched criteria (older than $AgeHours hours OR >= $([Math]::Round($SizeThresholdBytes/1GB,2)) GB)."
    Write-Log "----- Cleanup run finished -----"
    exit 0
}

foreach ($f in $targets) {
    $reason = @()
    if ($f.LastWriteTime -lt $cutoff) { $reason += "age>$AgeHours h (LastWriteTime=$($f.LastWriteTime))" }
    if ($f.Length -ge $SizeThresholdBytes) { $reason += ("size>={0:N2} GB" -f ($SizeThresholdBytes/1GB)) }

    # quotes only for LOG DISPLAY (not for -LiteralPath)
    $displayPath = "`"$($f.FullName)`""
    $msg = "DELETE: $displayPath | Size=$([Math]::Round($f.Length/1MB,2)) MB | Reason: " + ($reason -join " & ")

    if ($WhatIfRun) {
        Write-Log "[WHATIF] $msg"
        continue
    }

    try {
        # pass the RAW path (no embedded quotes) to -LiteralPath
        Remove-Item -LiteralPath $f.FullName -Force -ErrorAction Stop

        # verify deletion for ~2 seconds; if it reappears, truncate
        $gone = $true
        for ($i = 0; $i -lt 10; $i++) {
            Start-Sleep -Milliseconds 200
            if (Test-Path -LiteralPath $f.FullName) { $gone = $false; break }
        }

        if ($gone) {
            Write-Log $msg
        } else {
            Clear-Content -LiteralPath $f.FullName -Force -ErrorAction SilentlyContinue
            Write-Log "TRUNCATE-FALLBACK: $displayPath | Reason: re-created immediately after delete"
        }
    } catch {
        Write-Log "ERROR: Could not delete $displayPath. $_"
    }
}

Write-Log "----- Cleanup run finished -----"
