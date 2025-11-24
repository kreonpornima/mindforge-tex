<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Multiple Sheets to Excel</title>
    <script src="https://unpkg.com/xlsx@0.17.4/dist/xlsx.full.min.js"></script>
</head>
<body>

    <button onclick="exportToExcel()">Export to Excel</button>
    <button onclick="exportToExcel1()">GSTR1</button>

    <script>
        function getSheetData(sheetsMap, sheetName, XLSX, shDt){
            const sheetData = sheetsMap[sheetName]?.data || [];
            console.log(sheetName, shDt, sheetData, "<=");
            sheetData.forEach((row, i) => {
                const values = Object.values(row);
                XLSX.utils.sheet_add_aoa(shDt, [values], { origin: { r: 4 + i, c: 0 } }); // Start from row 6 (index 5)
            });
        }
        async function exportToExcel1() {
            try {
                // Simulate sending parameters like GridID, FormID, UserID, editID
                const GridID = 1;  // Example GridID
                const FormID = 123; // Example FormID
                const UserID = 456; // Example UserID
                const editID = 789; // Example editID

                // Simulating fetching data from PHP (using mock data)
                const response = await fetch('pornimaimportSpDataIntoExcel.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        GridID: GridID,
                        FormID: FormID,
                        UserID: UserID,
                        editID: editID
                    })
                });

                const jsonData = await response.json();
                console.log(jsonData);
                // Check if the response is valid
                if (jsonData.response === "true" && jsonData.sheets) {
                    let wb = XLSX.utils.book_new(); // Create a new workbook
                    var cnt = 1;
                    // Extract API sheets as a dictionary for easy access
                    const sheetsMap = {};
                    jsonData.sheets.forEach(s => {
                        sheetsMap[s.sheetName] = s;
                    });
                    var b2bSezDeData = [
                        ['Summary For B2B, SEZ, DE (4A, 4B, 6B, 6C)', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Recipients', 'No. of Invoices', 'Total Invoice Value', '', '', '', '', '', '', '', 'Total Taxable Value', 'Total Cess'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Reverse Charge', 'Applicable % of Tax Rate', 'Invoice Type', 'E-Commerce GSTIN', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let b2bSezDeSheet = XLSX.utils.aoa_to_sheet(b2bSezDeData);
                    b2bSezDeSheet['A3'] = { t: 'n', f: 'COUNTA(A5:A2000)' }; // Count recipients
                    b2bSezDeSheet['B3'] = { t: 'n', f: 'COUNTA(B5:B2000)' }; // Count invoices
                    b2bSezDeSheet['K3'] = { t: 'n', f: 'SUM(K5:K2000)' }; // Total Taxable Value
                    b2bSezDeSheet['L3'] = { t: 'n', f: 'SUM(L5:L2000)' }; // Total Cess
                    getSheetData(sheetsMap, 'b2b,sez,de', XLSX, b2bSezDeSheet)

                    var b2bData = [
                        ['Summary For B2B', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Recipients', 'No. of Invoices', 'Total Invoice Value', '', '', '', '', '', '', '', 'Total Taxable Value', 'Total Cess', '', ''],
                        [null, '', null, '', '', '', '', '', '', '', null, null, null, null],
                        ['GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Reverse Charge', 'Applicable % of Tax Rate', 'Invoice Type', 'E-Commerce GSTIN', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let b2bSheet = XLSX.utils.aoa_to_sheet(b2bData);
                    b2bSheet['A3'] = { t: 'n', f: 'SUMPRODUCT((A5:A20004<>"")/COUNTIF(A5:A20004,A5:A20004&""))' }; // Formula for cell A3
                    b2bSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Formula for cell C3
                    b2bSheet['G3'] = { t: 'n', f: 'SUM(G5:G2000)' }; // Formula for cell G3
                    b2bSheet['N3'] = { t: 'n', f: 'SUM(N5:N2000)' }; // Formula for cell N3
                    b2bSheet['O3'] = { t: 'n', f: 'SUM(O5:O2000)' }; // Formula for cell O3
                    getSheetData(sheetsMap, 'b2ba', XLSX, b2bSheet);

                    // b2cl Sheet
                    var b2clData = [
                        ['Summary For B2CL', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Invoices', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount'],
                        [null, '', null, '', '', '', null, null, null, null],
                        ['Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let b2clSheet = XLSX.utils.aoa_to_sheet(b2clData);
                    b2clSheet['B3'] = { t: 'n', f: 'COUNTA(B5:B2000)' }; // Count invoices

                    var b2claData = [
                        ['Summary For B2CLA (Amended B2C Large)', 'HELP', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Invoices', 'Total Inv Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Original Invoice Number', 'Original Invoice Date', 'Original Place Of Supply', 'Revised Invoice Number', 'Revised Invoice Date', 'Invoice Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
                    ];

                    let b2claSheet = XLSX.utils.aoa_to_sheet(b2claData);
                    b2claSheet['B3'] = { t: 'n', f: 'COUNTA(B5:B2000)' }; // Count invoices
                    b2claSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Taxable Value
                    b2claSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Cess

                    var b2csData = [
                        ['Summary For B2CS', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Type', 'Place Of Supply', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
                    ];
                    let b2csSheet = XLSX.utils.aoa_to_sheet(b2csData);
                    b2csSheet['A3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Taxable Value
                    b2csSheet['B3'] = { t: 'n', f: 'SUM(F5:F2000)' }; // Total Cess
                    getSheetData(sheetsMap, 'b2cs', XLSX, b2csSheet);
                    var b2csaData = [
                        ['Summary For B2CSA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Financial Year', 'Original Month', 'Place Of Supply', 'Type', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
                    ];
                    let b2csaSheet = XLSX.utils.aoa_to_sheet(b2csaData);
                    b2csaSheet['A3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Taxable Value
                    b2csaSheet['B3'] = { t: 'n', f: 'SUM(F5:F2000)' }; // Total Cess

                    // cdnr Sheet
                    var cdnrData = [
                        ['Summary For CDNR', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Recipients', 'No. of Notes', 'Total Note Value', 'Total Taxable Value', 'Total Cess', 'GSTIN/UIN of Recipient', 'Receiver Name', 'Note Number', 'Note Date', 'Note Type', 'Place Of Supply', 'Reverse Charge', 'Rate', 'Taxable Value', 'Cess Amount'],
                        [null, '', null, '', '', '', '', '', null, '', '', '', '', null, null],
                        ['GSTIN/UIN of Recipient', 'Receiver Name', 'Note Number', 'Note Date', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let cdnrSheet = XLSX.utils.aoa_to_sheet(cdnrData);
                    cdnrSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr

                    var cdnraData = [
                        ['Summary For CDNRA (Amended CDNR)', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Recipients', 'No. of Notes', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Original Note Number', 'Original Note Date', 'Revised Note Number', 'Revised Note Date', 'Note Type', 'Place Of Supply', 'Reverse Charge', 'Note Supply Type', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let cdnraSheet = XLSX.utils.aoa_to_sheet(cdnraData);
                    cdnraSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Note Value
                    cdnraSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
                    cdnraSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess

                    var cdnurData = [
                        ['Summary For CDNUR', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Notes/Vouchers', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['UR Type', 'Note Number', 'Note Date', 'Note Type', 'Place Of Supply', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let cdnurSheet = XLSX.utils.aoa_to_sheet(cdnurData);
                    cdnurSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr

                    var cdnuraData = [
                        ['Summary For CDNURA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Notes/Vouchers', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['UR Type', 'Original Note Number', 'Original Note Date', 'Revised Note Number', 'Revised Note Date', 'Note Type', 'Place Of Supply', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let cdnuraSheet = XLSX.utils.aoa_to_sheet(cdnuraData);
                    cdnuraSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr

                    var expData = [
                        ['Summary For EXP', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Invoices', 'Total Invoice Value', 'No. of Shipping Bills', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Export Type', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Port Code', 'Shipping Bill Number', 'Shipping Bill Date', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let expSheet = XLSX.utils.aoa_to_sheet(expData);
                    expSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Invoice Value
                    expSheet['C3'] = { t: 'n', f: 'COUNT(C5:C2000)' }; // Number of Shipping Bills
                    expSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
                    expSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess
                    var expaData = [
                        ['Summary For EXPA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of Invoices', 'Total Invoice Value', 'No. of Shipping Bills', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Export Type', 'Original Invoice Number', 'Original Invoice Date', 'Revised Invoice Number', 'Revised Invoice Date', 'Invoice Value', 'Port Code', 'Shipping Bill Number', 'Shipping Bill Date', 'Rate', 'Taxable Value', 'Cess Amount']
                    ];
                    let expaSheet = XLSX.utils.aoa_to_sheet(expaData);
                    expaSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Invoice Value
                    expaSheet['C3'] = { t: 'n', f: 'COUNT(C5:C2000)' }; // Number of Shipping Bills
                    expaSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
                    expaSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess

                    var atData = [
                        ['Summary For Advance Received', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Advance Received', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Place Of Supply', 'Rate', 'Gross Advance Received', 'Cess Amount']
                    ];
                    let atSheet = XLSX.utils.aoa_to_sheet(atData);
                    atSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Received
                    atSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess

                    var ataData = [
                        ['Summary For Amended Tax Liability (Advance Received)', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Advance Received', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Financial Year', 'Original Month', 'Original Place Of Supply', 'Rate', 'Gross Advance Received', 'Cess Amount']
                    ];
                    let ataSheet = XLSX.utils.aoa_to_sheet(ataData);
                    ataSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Received
                    ataSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess

                    var atadjData = [
                        ['Summary For Advance Adjusted', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Advance Adjusted', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Place Of Supply', 'Rate', 'Gross Advance Adjusted', 'Cess Amount']
                    ];
                    let atadjSheet = XLSX.utils.aoa_to_sheet(atadjData);
                    atadjSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Adjusted
                    atadjSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess

                    var atadjaData = [
                        ['Summary For Amendment of Adjustment Advances', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Advance Adjusted', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Financial Year', 'Original Month', 'Original Place Of Supply', 'Rate', 'Gross Advance Adjusted', 'Cess Amount']
                    ];
                    let atadjaSheet = XLSX.utils.aoa_to_sheet(atadjaData);
                    atadjaSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Adjusted
                    atadjaSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess
                    
                    var exempData = [
                        ['Summary For Nil Rated, Exempted, and Non-GST Supplies', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Nil Rated Supplies', 'Total Exempted Supplies', 'Total Non-GST Supplies', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Description', 'Nil Rated Supplies', 'Exempted Supplies', 'Non-GST Supplies']
                    ];
                    let exempSheet = XLSX.utils.aoa_to_sheet(exempData);
                    exempSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Nil Rated Supplies
                    exempSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Exempted Supplies
                    exempSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Non-GST Supplies

                    var hsnData = [
                        ['Summary For HSN', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['No. of HSN', 'Total Value', 'Total Taxable Value', 'Total Integrated Tax', 'Total Central Tax', 'Total State/UT Tax', 'Total Cess', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['HSN', 'Description', 'UQC', 'Total Quantity', 'Total Value', 'Rate', 'Taxable Value', 'Integrated Tax Amount', 'Central Tax Amount', 'State/UT Tax Amount', 'Cess Amount']
                    ];
                    let hsnSheet = XLSX.utils.aoa_to_sheet(hsnData);
                    hsnSheet['B3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Value
                    hsnSheet['C3'] = { t: 'n', f: 'SUM(G5:G2000)' }; // Total Taxable Value
                    hsnSheet['D3'] = { t: 'n', f: 'SUM(H5:H2000)' }; // Total Integrated Tax
                    hsnSheet['E3'] = { t: 'n', f: 'SUM(I5:I2000)' }; // Total Central Tax
                    hsnSheet['F3'] = { t: 'n', f: 'SUM(J5:J2000)' }; // Total State/UT Tax
                    hsnSheet['G3'] = { t: 'n', f: 'SUM(K5:K2000)' }; // Total Cess
                    getSheetData(sheetsMap, 'hsn', XLSX, hsnSheet);

                    var docsData = [
                        ['Summary of Documents Issued During the Tax Period', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        ['Total Number of Documents', 'Total Cancelled Documents', '', '', '', '', '', '', '', '', '', '', 'HELP'],
                        [null, '', null, '', '', '', null, '', '', '', '', null, null],
                        ['Nature of Document', 'Sr. No. From', 'Sr. No. To', 'Total Number of Documents', 'Cancelled']
                    ];
                    let docsSheet = XLSX.utils.aoa_to_sheet(docsData);
                    docsSheet['B3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Number of Documents
                    docsSheet['C3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cancelled Documents



                    // Step 3: Add these sheets to a workbook
                     wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, b2bSezDeSheet, 'b2b,sez,de');
                    XLSX.utils.book_append_sheet(wb, b2bSheet, 'b2ba');
                    XLSX.utils.book_append_sheet(wb, b2clSheet, 'b2cl');
                    XLSX.utils.book_append_sheet(wb, b2claSheet, 'b2cla');
                    XLSX.utils.book_append_sheet(wb, b2csSheet, 'b2cs');
                    XLSX.utils.book_append_sheet(wb, b2csaSheet, 'b2csa');
                    XLSX.utils.book_append_sheet(wb, cdnrSheet, 'cdnr');
                    XLSX.utils.book_append_sheet(wb, cdnraSheet, 'cdnra');
                    XLSX.utils.book_append_sheet(wb, cdnurSheet, 'cdnur');
                    XLSX.utils.book_append_sheet(wb, cdnuraSheet, 'cdnura');
                    XLSX.utils.book_append_sheet(wb, expSheet, 'exp');
                    XLSX.utils.book_append_sheet(wb, expaSheet, 'expa');
                    XLSX.utils.book_append_sheet(wb, atSheet, 'at');
                    XLSX.utils.book_append_sheet(wb, ataSheet, 'ata');
                    XLSX.utils.book_append_sheet(wb, atadjSheet, 'atadj');
                    XLSX.utils.book_append_sheet(wb, atadjaSheet, 'atadja');
                    XLSX.utils.book_append_sheet(wb, exempSheet, 'exemp');
                    XLSX.utils.book_append_sheet(wb, hsnSheet, 'hsn');
                    XLSX.utils.book_append_sheet(wb, docsSheet, 'docs');

                    // Step 4: Write the workbook to an Excel file
                    XLSX.writeFile(wb, 'GSTR1.xlsx');



                /*
                    jsonData.sheets.forEach(sheet => {
                        if(cnt == 1){
                            var staticData = [
                                ['Summary of b2b', 'Original Details', '', '', 'Revised Details', '', '', '', '', '', '', '', '', '', 'HELP'],
                                ['No. of Recipients', '', 'No. of Invoices', '', '', '', 'Total Invoice Value', '', '', '', '', '', '', 'Total Taxable Value', 'Total Cess'],
                                [null, '', null, '', '', '', null, '', '', '', '', '', '', null, null],
                                ['GSTIN/UIN of Recipient','Receiver Name','Original Invoice Number','Original Invoice date','Revised Invoice Number','Revised Invoice date','Invoice Value','Place Of Supply','Reverse Charge','Applicable % of Tax Rate','Invoice Type','E-Commerce GSTIN','Rate','Taxable Value','Cess Amount' ]
                            ];
                            // Step 1: Create worksheet with static data
                            let ws = XLSX.utils.aoa_to_sheet(staticData);

                            // Step 2: Add formulas explicitly for specific cells
                            ws['A3'] = { t: 'n', f: 'SUMPRODUCT((A5:A20004<>"")/COUNTIF(A5:A20004,A5:A20004&""))' }; // Formula for cell A3
                            ws['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Formula for cell C3
                            ws['G3'] = { t: 'n', f: 'SUM(G5:G2000)' }; // Formula for cell G3
                            ws['N3'] = { t: 'n', f: 'SUM(N5:N2000)' }; // Formula for cell N3
                            ws['O3'] = { t: 'n', f: 'SUM(O5:O2000)' }; // Formula for cell O3
                        }
                        
                        // Step 3: Add JSON data starting at cell A5
                        XLSX.utils.sheet_add_json(ws, sheet.data, {
                            // header: sheet.headers,
                            origin: "A4" // Start JSON data from cell A5
                        });

                        // Step 4: Append the sheet to the workbook
                        XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
                        cnt++;
                    });

                    // Step 5: Export the Excel file
                    XLSX.writeFile(wb, 'GSTR1.xlsx');*/
                } else {
                    alert('No data found or error fetching data.');
                }

            } catch (error) {
                console.error('Error during export:', error);
            }
        }
        async function exportToExcel() {
            try {
                // Simulate sending parameters like GridID, FormID, UserID, editID
                const GridID = 1;  // Example GridID
                const FormID = 123; // Example FormID
                const UserID = 456; // Example UserID
                const editID = 789; // Example editID

                // Fetch data from the PHP script
                const response = await fetch('pornimaimportSpDataIntoExcel.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        GridID: GridID,
                        FormID: FormID,
                        UserID: UserID,
                        editID: editID
                    })
                });

                const jsonData = await response.json();
                console.log(jsonData);

                // Validate response data
                if (jsonData.response === "true" && jsonData.sheets) {
                    const wb = XLSX.utils.book_new();  // Create a new workbook

                    jsonData.sheets.forEach(sheet => {
                        // Convert data objects into an array of arrays
                        const formattedData = sheet.data.map(row => sheet.headers.map(header => row[header] || ""));

                        // Create worksheet with headers and formatted data
                        const ws = XLSX.utils.aoa_to_sheet([sheet.headers, ...formattedData]);

                        // Append worksheet to workbook
                        XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
                    });

                    // Export the workbook to an Excel file
                    XLSX.writeFile(wb, 'exported_data.xlsx');
                } else {
                    alert('No data found or error fetching data.');
                }

            } catch (error) {
                console.error('Error during export:', error);
            }
        }

        // async function exportToExcel() {
        //     try {
        //         // Simulate sending parameters like GridID, FormID, UserID, editID
        //         const GridID = 1;  // Example GridID
        //         const FormID = 123; // Example FormID
        //         const UserID = 456; // Example UserID
        //         const editID = 789; // Example editID

        //         // Simulating fetching data from PHP (using mock data)
        //         const response = await fetch('pornimaimportSpDataIntoExcel.php', {
        //             method: 'POST',
        //             body: new URLSearchParams({
        //                 GridID: GridID,
        //                 FormID: FormID,
        //                 UserID: UserID,
        //                 editID: editID
        //             })
        //         });

        //         const jsonData = await response.json();
        //         console.log(jsonData)
        //         // Check if the response is valid
        //         if (jsonData.response === "true" && jsonData.sheets) {
        //             const wb = XLSX.utils.book_new();  // Create a new workbook

        //             // Iterate over each sheet in the response
        //             jsonData.sheets.forEach(sheet => {
        //                 const ws = XLSX.utils.aoa_to_sheet(sheet.data);

        //                 // Add JSON data starting at cell A5
        //                 XLSX.utils.sheet_add_json(ws, sheet.data, {
        //                     header: sheet.headers,
        //                     origin: "A5" // Start JSON data from cell A5
        //                 });

        //                 // Append the sheet to the workbook
        //                 XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
        //             });

        //             // Export the Excel file
        //             XLSX.writeFile(wb, 'exported_data.xlsx');
        //         } else {
        //             alert('No data found or error fetching data.');
        //         }

        //     } catch (error) {
        //         console.error('Error during export:', error);
        //     }
        // }
    </script>

</body>
</html>
