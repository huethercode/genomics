# genomics_dash


# Documentation of Files
File NameResponsibilityTech Used
index.phpThe UI shell. Defines where charts and tables appear.
HTML5 / Bootstrapapi.phpParses VCF/TSV, filters by GQ, and calculates QC stats.PHP 8+charts.jsDraws SVG Karyoplots, histograms, and frequency plots.D3.js v7app.jsHandles the "Analyze" button click and AJAX file upload.Vanilla JS / Fetchstyle.cssHandles SVG responsiveness and custom typography.CSS3functions.phpModular logic for genomic string parsing.PHP


# genomics-app/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styling (Journal theme)
│   ├── js/
│   │   ├── app.js             # State management & UI Logic
│   │   ├── charts.js          # D3.js visualization functions
│   │   └── d3.v7.min.js       # D3 Library (CDN or Local)
├── data/
│   ├── refdata/               # ACMG, PRS, Wellness CSVs
│   └── uploads/               # Temporary folder for user VCFs
├── includes/
│   ├── functions.php          # Genomic math (Ts/Tv, filters)
│   └── config.php             # Constants and paths
├── index.php                  # Main Application Dashboard
└── api.php                    # JSON API endpoint for data processing