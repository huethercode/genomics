// api.php
header('Content-Type: application/json');
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['vcf'])) {
    $file = $_FILES['vcf']['tmp_name'];
    $variants = [];
    $qc = ['ts' => 0, 'tv' => 0, 'dp_sum' => 0, 'gq_sum' => 0, 'count' => 
0];

    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, "\t")) !== FALSE) {
            // Mapping: 0:CHRM, 1:POS, 2:REF, 3:ALT, 4:DP, 5:GQ, 6:AF
            $dp = (float)$data[4];
            $gq = (float)$data[5];

            if ($gq >= 30) { // GQ Filter from your R code
                $variants[] = [
                    'chr' => $data[0],
                    'pos' => (int)$data[1],
                    'ref' => $data[2],
                    'alt' => $data[3],
                    'dp'  => $dp,
                    'af'  => (float)$data[6]
                ];
                
                // Track Ts/Tv
                $mut = $data[2] . ">" . $data[3];
                isTransition($mut) ? $qc['ts']++ : $qc['tv']++;
                $qc['dp_sum'] += $dp;
                $qc['count']++;
            }
        }
        fclose($handle);
    }

    echo json_encode([
        'qc' => [
            'ts_tv' => $qc['tv'] > 0 ? $qc['ts'] / $qc['tv'] : 0,
            'mean_dp' => $qc['count'] > 0 ? $qc['dp_sum'] / $qc['count'] : 
0,
            'count' => $qc['count']
        ],
        'variants' => $variants
    ]);
}
