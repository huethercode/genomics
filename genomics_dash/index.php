<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Genomics Report v1 | PHP & D3</title>
    <link rel="stylesheet" 
href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/journal/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid"><a class="navbar-brand" 
href="#">Genomics Dashboard</a></div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-secondary mb-3">
                    <div class="card-header">Data Import</div>
                    <div class="card-body">
                        <input type="file" id="vcfFile" 
class="form-control mb-3">
                        <button id="btnAnalyze" class="btn btn-primary 
w-100">Run Analysis</button>
                    </div>
                </div>
                <div id="qc-summary" class="card p-3 shadow-sm">
                    </div>
            </div>

            <div class="col-md-9">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item"><a class="nav-link active" 
data-bs-toggle="tab" href="#qc">QC & Density</a></li>
                    <li class="nav-item"><a class="nav-link" 
data-bs-toggle="tab" href="#hereditary">Hereditary</a></li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="qc">
                        <div class="row">
                            <div class="col-12 border p-3 bg-white" 
id="karyo-container">
                                <h5>Genome-wide Variant Density</h5>
                                <div id="karyoplot"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6" 
id="indel-chart"><h5>Indel Distribution</h5></div>
                            <div class="col-md-6" id="af-chart"><h5>Allele 
Frequency</h5></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="hereditary">
                        <table id="acmg-table" class="table 
table-hover"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/charts.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
