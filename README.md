# Personal Genomics Report Pipeline

This repository contains the driver script and instructions for running a personalized genomics report pipeline. The pipeline processes VCF files through various tools to generate a comprehensive report, including variant annotation, ancestry analysis, polygenic risk score (PRS) calculation, and final report generation using R Markdown.

- Genetic Health (Prediposition)
- Fitness (Performance)
- Longevity-Wellness (weight/age)
- Ancestry
- PGx (pharmacogenetics testing)
- IGG test
- Gut Heath
- Vitamin/ Nutrition panel

## Pipeline Overview

The pipeline consists of the following steps:

1.  **Configuration:** Reads input configuration.
2.  **Output Folder Creation:** Creates a unique output folder for each run.
3.  **Variant Annotation (OpenCRAVAT):**
    * Checks for VCF files.
    * Runs OpenCRAVAT (OC) for variant annotation.
    * Saves output in TSV format.
    * **Manual Steps:**
        * Launch OC GUI.
        * Run annotations: ClinVar, REVEL, alphaMissense, BayesDel, PharmGKB.
        * Apply filters (coding-yes, very important) and expand ClinVar tab.
        * Save the filtered variant table as `oc.tsv`.
4.  **Ancestry Analysis (snvstory):**
    * Uses a Docker-based tool (`snvstory`) for ancestry estimation.
    * **Manual Steps:**
        * Navigate to the `snvstory` directory.
        * Build the Docker image: `docker-compose build`.
        * Run the ancestry analysis using `docker-compose run` with appropriate VCF and reference data paths.
        * Copy the output HTML file (`NORMAL_gnomAD_umap.html`) and associated plot (`gnomad_plot.png`) to the run output folder.
5.  **Polygenic Risk Score (PRS) Calculation (PRSKB CLI):**
    * Uses the PRSKB CLI tool to calculate PRS.
    * **Preprocessing:**
        * Adds MAF INFO field to the VCF header.
        * Normalizes and merges the VCF using `bcftools`.
    * Runs PRS calculation with different p-value thresholds.
    * Moves the PRS output file (`prs.tsv`) to the run output folder.
    * Creates a minimal variant TSV file for R processing.
6.  **Report Generation (R Markdown):**
    * Uses an R Markdown script (`genomics_report.Rmd`) to compile all results into a final HTML report.

## Usage

### Prerequisites

* Docker and Docker Compose
* OpenCRAVAT
* PRSKB CLI
* R and R Markdown

### Steps

1.  **Clone the Repository:**

    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```

2.  **Configure OpenCRAVAT (Manual):**

    * Follow the manual steps described in the "Variant Annotation" section above.

3.  **Run Ancestry Analysis (Docker):**

    * Navigate to the `snvstory` directory: `cd snvstory`.
    * Build the Docker image: `docker-compose build`.
    * Run the analysis, replacing the VCF paths with your input VCF, and adjust the genome version as needed.

        ```bash
        docker-compose run -v /path/to/genomics:/path/to/genomics ancestry \
        --path /path/to/genomics/output/<run_id>/<your_vcf>.vcf \
        --resource /path/to/genomics/refdata/ \
        --output-dir /path/to/genomics/output/<run_id> \
        --genome-ver <37 or 38> \
        --mode <WES or WGS> \
        --output_filename exome_ancestry \
        --logging /path/to/genomics/output/<run_id>/ancestry_log.txt
        ```

    * Copy the output files to the run output folder.

4.  **Run PRS Calculation (PRSKB CLI):**

    * Navigate to the `prs` directory: `cd prs`.
    * Preprocess the VCF as described in the "PRS Calculation" section.
    * Run the PRS calculation, replacing the VCF path and adjusting parameters as needed:

        ```bash
        ./runPrsCLI.sh -f ../output/<run_id>/<preprocessed_vcf>.vcf -o prs.tsv -r <hg19 or hg38> -c <p_value_threshold> -p EUR -v
        ```

    * Move the `prs.tsv` file to the run output folder.
    * create a subset tab file for r markdown.
        ```bash
        bcftools query -f '%CHROM\t%POS\t%REF\t%ALT\t[%DP\t%GQ\t%AF\t%AD]\n' <your_vcf>.vcf > <your_vcf>_subset.tab
        ```

5.  **Generate the Report (R Markdown):**

    * Navigate to the `report` directory: `cd report`.
    * Run the R Markdown script:

        ```bash
        Rscript -e 'library(rmarkdown); rmarkdown::render("genomics_report.Rmd", "html_document")'
        ```

    * The final report will be generated as an HTML file.

## Notes

* Replace placeholder paths and file names with your actual data.
* Ensure that the required tools and dependencies are installed and accessible.
* Adjust parameters and thresholds as needed for your specific analysis.
* The manual steps in OpenCRAVAT are crucial for accurate variant filtering and annotation.
* The provided commands are examples; adapt them to your specific file paths and requirements.

