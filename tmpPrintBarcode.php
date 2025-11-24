<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auto-Adjust Font Size for Printing</title>
  <style>
    .resize-text {
      padding: 10px;
      white-space: nowrap; /* Prevent text from wrapping */
      overflow: hidden;   /* Hide any overflow content */
      text-align: center;
      background-color: lightgray;
      border: 1px solid #ccc;
    }

    /* Styles for the print */
    @media print {
      body {
        margin: 0;
      }

      .resize-text {
        font-size: 20px; /* Default font size when printing */
      }
    }
  </style>
</head>
<body>

<!-- Fixed-width container with text -->
<div id="resizeText" class="resize-text">
  This is some long text that will be resized to fit within the container when printed.
</div>

<button onclick="adjustFontSizeAndPrint()">Print</button>

<script>
  // Function to adjust the font size dynamically to fit the container
  function adjustFontSizeAndPrint() {
    const container = document.getElementById('resizeText');
    const pageWidthMM = 140; // Example: 210 mm width (standard A4 page width)
    const dpi = 96; // Assuming 96 DPI for screen/web printing (adjust if needed)

    // Convert page width from mm to pixels (for 96 DPI)
    const pageWidthPixels = pageWidthMM * (dpi / 25.4);

    // Set the fixed width of the container based on pageWidth in mm
    container.style.width = `${pageWidthPixels}px`;

    const containerWidth = container.offsetWidth;
    const text = container.innerText || container.textContent;

    // Calculate font size dynamically to fit within container
    let fontSize = 100; // Starting font size as a percentage
    let textWidth = getTextWidth(text, fontSize);

    // Decrease the font size until the text fits within the container width
    while (textWidth > containerWidth && fontSize > 10) {
      fontSize -= 1;
      textWidth = getTextWidth(text, fontSize);
    }

    // Set the new font size on the container
    container.style.fontSize = fontSize + '%';

    // Trigger the print dialog
    window.print();
  }

  // Function to calculate the width of the text based on the font size
  function getTextWidth(text, fontSize) {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    context.font = fontSize + 'px'; // Use the font size
    const width = context.measureText(text).width;
    return width;
  }
</script>

</body>
</html>
