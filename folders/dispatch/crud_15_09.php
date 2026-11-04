Step 1 — Final folder structure

We are going to create this automatically:

/var/www/html/otm_beta/uploads/dispatch/

+-- 2024-2025/
¦   +-- CHN-DC-2525-Dispatch.pdf
¦   +-- CHN-DC-2525-Transit.pdf
¦   +-- CHN-DC-2525-POD.pdf
¦
+-- 2025-2026/
¦   +-- CHN-DC-2525-Dispatch.pdf
¦   +-- CHN-DC-2525-Transit.pdf
¦   +-- CHN-DC-2525-POD.pdf
¦
+-- 2026-2027/
    +-- CHN-DC-2525-Dispatch.pdf
    +-- CHN-DC-2525-Transit.pdf
    +-- CHN-DC-2525-POD.pdf

Example:

DC No:
CHN/DC/2525

Invoice No:
CHN/26-27/3312

We use:

invoice_no
CHN/26-27/3312

        ?

26-27

        ?

2026-2027

So the DC file goes to:

uploads/dispatch/2026-2027/
Step 2 — Add common helper functions

Go to the bottom of your Dispatch CRUD PHP file.

Add these functions before image_view().

/* =========================================================
   GET ACADEMIC YEAR FROM INVOICE NUMBER

   CHN/26-27/3312
   =>
   2026-2027
   ========================================================= */

function getAcademicYearFromInvoiceNo($invoice_no)
{
    $invoice_no = trim((string)$invoice_no);

    if ($invoice_no === '') {
        return '';
    }


    /*
     * Full format:
     *
     * CHN/2026-2027/3312
     */
    if (
        preg_match(
            '~(?:^|/)(20\d{2})-(20\d{2})(?:/|$)~',
            $invoice_no,
            $matches
        )
    ) {

        return
            $matches[1]
            . '-'
            . $matches[2];
    }


    /*
     * Short format:
     *
     * CHN/26-27/3312
     */
    if (
        preg_match(
            '~(?:^|/)(\d{2})-(\d{2})(?:/|$)~',
            $invoice_no,
            $matches
        )
    ) {

        $startShort =
            (int)$matches[1];

        $endShort =
            (int)$matches[2];


        $startYear =
            2000 + $startShort;

        $endYear =
            2000 + $endShort;


        /*
         * Handles:
         * 99-00 etc.
         */
        if ($endYear < $startYear) {

            $endYear =
                $startYear + 1;
        }


        return
            $startYear
            . '-'
            . $endYear;
    }


    return '';
}


/* =========================================================
   DATE FALLBACK

   If some old invoice number does not contain year,
   calculate financial year using date.

   April - March
   ========================================================= */

function getFinancialYearFromDate($date_value)
{
    $date_value =
        trim((string)$date_value);


    if ($date_value === '') {
        return '';
    }


    $timestamp =
        strtotime($date_value);


    if (!$timestamp) {
        return '';
    }


    $year =
        (int)date(
            'Y',
            $timestamp
        );


    $month =
        (int)date(
            'n',
            $timestamp
        );


    if ($month >= 4) {

        $startYear =
            $year;

        $endYear =
            $year + 1;

    } else {

        $startYear =
            $year - 1;

        $endYear =
            $year;
    }


    return
        $startYear
        . '-'
        . $endYear;
}


/* =========================================================
   DISPATCH ACADEMIC YEAR

   Priority:

   1. Invoice Number
   2. Invoice Date
   3. PO Date

   NEVER depend on DC Number.
   ========================================================= */

function getDispatchAcademicYear(
    $invoice_no = '',
    $invoice_date = '',
    $po_date = ''
) {

    /*
     * Priority 1
     */
    $academic_year =
        getAcademicYearFromInvoiceNo(
            $invoice_no
        );


    if ($academic_year !== '') {

        return $academic_year;
    }


    /*
     * Priority 2
     */
    $academic_year =
        getFinancialYearFromDate(
            $invoice_date
        );


    if ($academic_year !== '') {

        return $academic_year;
    }


    /*
     * Priority 3
     */
    return
        getFinancialYearFromDate(
            $po_date
        );
}


/* =========================================================
   SAFE DC NUMBER FOR FILE NAME

   CHN/DC/2525

   becomes

   CHN-DC-2525
   ========================================================= */

function getSafeDispatchNumber($dc_no)
{
    $safe =
        preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '-',
            trim((string)$dc_no)
        );


    return
        trim(
            $safe,
            '-'
        );
}


/* =========================================================
   CREATE ACADEMIC YEAR DIRECTORY

   Example:

   uploads/dispatch/2026-2027/
   ========================================================= */

function prepareAcademicUploadFolder(
    $folder_name,
    $invoice_no = '',
    $invoice_date = '',
    $po_date = ''
) {

    $academic_year =
        getDispatchAcademicYear(
            $invoice_no,
            $invoice_date,
            $po_date
        );


    if ($academic_year === '') {

        throw new Exception(
            'Unable to identify Academic Year from Invoice Number: '
            . $invoice_no
        );
    }


    /*
     * Current CRUD relative location:
     *
     * ../../uploads/
     */
    $base_directory =
        __DIR__
        . '/../../uploads/'
        . trim(
            $folder_name,
            '/'
        )
        . '/';


    /*
     * Create base folder if required
     */
    if (!is_dir($base_directory)) {

        if (
            !mkdir(
                $base_directory,
                0775,
                true
            )
            &&
            !is_dir($base_directory)
        ) {

            throw new Exception(
                'Unable to create base upload folder: '
                . $base_directory
            );
        }
    }


    /*
     * Academic year folder
     */
    $year_directory =
        $base_directory
        . $academic_year
        . DIRECTORY_SEPARATOR;


    /*
     * Automatically create if not exists
     */
    if (!is_dir($year_directory)) {

        if (
            !mkdir(
                $year_directory,
                0775,
                true
            )
            &&
            !is_dir($year_directory)
        ) {

            throw new Exception(
                'Unable to create academic year folder: '
                . $year_directory
            );
        }
    }


    return [
        'academic_year' =>
            $academic_year,

        'directory' =>
            $year_directory
    ];
}


/* =========================================================
   RESOLVE OLD + NEW FILES

   Supports:

   OLD:
   uploads/dispatch/2525-Dispatch.pdf

   MANUALLY RESTORED:
   uploads/dispatch/2025-2026/2525-Dispatch.pdf

   NEW:
   uploads/dispatch/2026-2027/CHN-DC-2525-Dispatch.pdf
   ========================================================= */

function resolveAcademicFilePath(
    $folder_name,
    $file_name,
    $invoice_no = '',
    $invoice_date = '',
    $po_date = ''
) {

    $file_name =
        trim((string)$file_name);


    if ($file_name === '') {

        return '';
    }


    /*
     * Normalize Windows/Linux slash
     */
    $normalized_file =
        str_replace(
            '\\',
            '/',
            $file_name
        );


    /*
     * If DB already contains:
     *
     * 2026-2027/file.pdf
     *
     * use as it is.
     */
    if (
        strpos(
            $normalized_file,
            '/'
        ) !== false
    ) {

        return
            ltrim(
                $normalized_file,
                '/'
            );
    }


    $academic_year =
        getDispatchAcademicYear(
            $invoice_no,
            $invoice_date,
            $po_date
        );


    $base_directory =
        __DIR__
        . '/../../uploads/'
        . trim(
            $folder_name,
            '/'
        )
        . '/';


    /*
     * First check academic year folder
     */
    if ($academic_year !== '') {

        $year_file =
            $base_directory
            . $academic_year
            . DIRECTORY_SEPARATOR
            . $file_name;


        if (is_file($year_file)) {

            return
                $academic_year
                . '/'
                . $file_name;
        }
    }


    /*
     * Old flat folder fallback
     *
     * uploads/dispatch/file.pdf
     */
    $old_file =
        $base_directory
        . $file_name;


    if (is_file($old_file)) {

        return
            $file_name;
    }


    /*
     * Default expected location
     */
    if ($academic_year !== '') {

        return
            $academic_year
            . '/'
            . $file_name;
    }


    return
        $file_name;
}
Step 3 — Change createupdate

Find this existing code:

$parts = explode('/', $dc_no);

$po_num_value = end($parts);

$allowedExts = array('pdf');

$extension = pathinfo(
    $_FILES['file']['name'],
    PATHINFO_EXTENSION
);

if (
    $_FILES['file']['type'] == 'application/pdf'
    &&
    in_array(
        strtolower($extension),
        $allowedExts
    )
) {

    $tem_name =
        $po_num_value
        . "-Dispatch"
        . '.pdf';

    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        '../../uploads/dispatch/'
        . $tem_name
    );

    $file_names =
        $tem_name;

    $file_org_names =
        $_FILES['file']['name'];
}

Remove that complete section.

Replace with:

/* =========================================================
   DISPATCH E-INVOICE UPLOAD
   ========================================================= */

$file_names = '';
$file_org_names = '';


if (
    isset($_FILES['file'])
    &&
    isset($_FILES['file']['error'])
    &&
    $_FILES['file']['error'] === UPLOAD_ERR_OK
    &&
    !empty($_FILES['file']['name'])
) {

    try {

        /* ---------------------------------------------
           Validate extension
           --------------------------------------------- */

        $extension =
            strtolower(
                pathinfo(
                    $_FILES['file']['name'],
                    PATHINFO_EXTENSION
                )
            );


        $allowedExts = [
            'pdf'
        ];


        if (
            !in_array(
                $extension,
                $allowedExts,
                true
            )
        ) {

            throw new Exception(
                'Only PDF file is allowed for E-Invoice.'
            );
        }


        /* ---------------------------------------------
           Get / create academic year folder

           Uses invoice_no first.
           --------------------------------------------- */

        $uploadInfo =
            prepareAcademicUploadFolder(
                'dispatch',
                $invoice_no,
                $invoice_date,
                $po_date
            );


        $academic_year =
            $uploadInfo[
                'academic_year'
            ];


        $targetDir =
            $uploadInfo[
                'directory'
            ];


        /* ---------------------------------------------
           Safe DC filename

           CHN/DC/2525

           =>

           CHN-DC-2525
           --------------------------------------------- */

        $safe_dc_no =
            getSafeDispatchNumber(
                $dc_no
            );


        /* ---------------------------------------------
           Final filename

           CHN-DC-2525-Dispatch.pdf
           --------------------------------------------- */

        $tem_name =
            $safe_dc_no
            . '-Dispatch.'
            . $extension;


        $destination =
            $targetDir
            . $tem_name;


        /* ---------------------------------------------
           Move uploaded file
           --------------------------------------------- */

        if (
            !move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $destination
            )
        ) {

            throw new Exception(
                'Unable to move Dispatch file to: '
                . $destination
            );
        }


        /*
         * IMPORTANT:
         *
         * Keep ONLY filename in database.
         *
         * Database:
         * CHN-DC-2525-Dispatch.pdf
         *
         * Actual physical path:
         * 2026-2027/CHN-DC-2525-Dispatch.pdf
         */

        $file_names =
            $tem_name;


        $file_org_names =
            $_FILES['file']['name'];


    } catch (Throwable $e) {

        echo json_encode([
            'status' => false,
            'msg' => 'error',
            'error' =>
                $e->getMessage()
        ]);

        exit;
    }
}

So this:

Invoice:
CHN/26-27/3312

DC:
CHN/DC/2525

creates:

/var/www/html/otm_beta/uploads/dispatch/
+-- 2026-2027/
    +-- CHN-DC-2525-Dispatch.pdf
Step 4 — Fix duplicate checking

This is important if your DC sequence repeats between academic years.

Currently you have:

$select_where =
    'is_delete = 0
     AND dc_number ="'
    . $dc_no
    . '"';

If CHN/DC/2525 is repeated next academic year, the old record can cause "already".

Change it to:

$select_where =
    'is_delete = 0
     AND dc_number = "'
    . $dc_no
    . '"
     AND invoice_no = "'
    . $invoice_no
    . '"';

And if this action supports update, add:

if (!empty($unique_id)) {

    $select_where .=
        ' AND unique_id != "'
        . $unique_id
        . '"';
}

Full code:

$table_details = [
    $table_dispatch,
    [
        'COUNT(dc_number) AS count'
    ]
];


$select_where =
    'is_delete = 0
     AND dc_number = "'
    . $dc_no
    . '"
     AND invoice_no = "'
    . $invoice_no
    . '"';


if (!empty($unique_id)) {

    $select_where .=
        ' AND unique_id != "'
        . $unique_id
        . '"';
}


$action_obj =
    $pdo->select(
        $table_details,
        $select_where
    );
Step 5 — Change deleivery_status

Now fix Transit + POD upload.

In:

case 'deleivery_status':

remove this old upload code:

$parts = explode('/', $dc_no);

$po_num_value = end($parts);

$file = $_FILES['file']['name'];
$podfile = $_FILES['podfile']['name'];

$extension = pathinfo(
    $_FILES['file']['name'],
    PATHINFO_EXTENSION
);

$podextension = pathinfo(
    $_FILES['podfile']['name'],
    PATHINFO_EXTENSION
);

$tem_name =
    $po_num_value
    . "-Transit."
    . $extension;

$podtem_name =
    $po_num_value
    . "-POD."
    . $podextension;


if (
    move_uploaded_file(
        $_FILES['file']['tmp_name'],
        '../../uploads/dispatch/'
        . $tem_name
    )
) {

    $file_names =
        $tem_name;

    $file_org_names =
        $_FILES['file']['name'];
}


if (
    move_uploaded_file(
        $_FILES['podfile']['tmp_name'],
        '../../uploads/dispatch/'
        . $podtem_name
    )
) {

    $podfile_names =
        $podtem_name;

    $podfile_org_names =
        $_FILES['podfile']['name'];
}

Replace it with this complete block.

/* =========================================================
   DEFAULT FILE VARIABLES
   ========================================================= */

$file_names = '';
$file_org_names = '';

$podfile_names = '';
$podfile_org_names = '';


/* =========================================================
   FETCH DISPATCH META

   This makes the backend safe even if invoice_no
   is not posted from the Delivery JS.
   ========================================================= */

$dispatchMetaResult =
    $pdo->select(
        [
            'dispatch_list',
            [
                'invoice_no',
                'invoice_date',
                'po_date'
            ]
        ],
        "po_form_unique_id = '"
        . $po_form_unique_id
        . "'
         AND consignee_unique_id = '"
        . $consignee_unique_id
        . "'
         AND dc_number = '"
        . $dc_no
        . "'
         AND is_delete = 0"
    );


$meta_invoice_no =
    $invoice_no ?? '';

$meta_invoice_date = '';

$meta_po_date = '';


if (
    $dispatchMetaResult->status
    &&
    !empty(
        $dispatchMetaResult->data
    )
) {

    if (empty($meta_invoice_no)) {

        $meta_invoice_no =
            $dispatchMetaResult
                ->data[0]['invoice_no']
            ?? '';
    }


    $meta_invoice_date =
        $dispatchMetaResult
            ->data[0]['invoice_date']
        ?? '';


    $meta_po_date =
        $dispatchMetaResult
            ->data[0]['po_date']
        ?? '';
}


/* =========================================================
   PREPARE YEAR DIRECTORY
   ========================================================= */

try {

    $uploadInfo =
        prepareAcademicUploadFolder(
            'dispatch',
            $meta_invoice_no,
            $meta_invoice_date,
            $meta_po_date
        );


    $targetDir =
        $uploadInfo[
            'directory'
        ];


    $safe_dc_no =
        getSafeDispatchNumber(
            $dc_no
        );


    $allowedExts = [
        'pdf',
        'jpg',
        'jpeg',
        'png',
        'xls',
        'xlsx'
    ];


    /* =====================================================
       TRANSIT FILE
       ===================================================== */

    if (
        isset($_FILES['file'])
        &&
        isset($_FILES['file']['error'])
        &&
        $_FILES['file']['error'] === UPLOAD_ERR_OK
        &&
        !empty($_FILES['file']['name'])
    ) {

        $extension =
            strtolower(
                pathinfo(
                    $_FILES['file']['name'],
                    PATHINFO_EXTENSION
                )
            );


        if (
            !in_array(
                $extension,
                $allowedExts,
                true
            )
        ) {

            throw new Exception(
                'Invalid Transit file type.'
            );
        }


        $tem_name =
            $safe_dc_no
            . '-Transit.'
            . $extension;


        $destination =
            $targetDir
            . $tem_name;


        if (
            !move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $destination
            )
        ) {

            throw new Exception(
                'Transit file upload failed.'
            );
        }


        $file_names =
            $tem_name;


        $file_org_names =
            $_FILES['file']['name'];
    }


    /* =====================================================
       POD FILE
       ===================================================== */

    if (
        isset($_FILES['podfile'])
        &&
        isset($_FILES['podfile']['error'])
        &&
        $_FILES['podfile']['error'] === UPLOAD_ERR_OK
        &&
        !empty($_FILES['podfile']['name'])
    ) {

        $podextension =
            strtolower(
                pathinfo(
                    $_FILES['podfile']['name'],
                    PATHINFO_EXTENSION
                )
            );


        if (
            !in_array(
                $podextension,
                $allowedExts,
                true
            )
        ) {

            throw new Exception(
                'Invalid POD file type.'
            );
        }


        $podtem_name =
            $safe_dc_no
            . '-POD.'
            . $podextension;


        $podDestination =
            $targetDir
            . $podtem_name;


        if (
            !move_uploaded_file(
                $_FILES['podfile']['tmp_name'],
                $podDestination
            )
        ) {

            throw new Exception(
                'POD file upload failed.'
            );
        }


        $podfile_names =
            $podtem_name;


        $podfile_org_names =
            $_FILES['podfile']['name'];
    }


} catch (Throwable $e) {

    echo json_encode([
        'status' => false,
        'msg' => 'error',
        'error' =>
            $e->getMessage()
    ]);

    exit;
}
Step 6 — Change $columns in deleivery_status

Don't blindly save empty filenames.

Instead of:

$columns = [
    "delivery_status" => $delivery_status,
    "delivery_date" => $delivery_date,
    'delivery_proof' => $file_names,
    'file_name' => $file_names,
    'file_org_name' => $file_org_names,
    'pod_proof' => $podfile_names,
    'podfile_org_name' => $podfile_org_names,
    "status" => 2,
    "mode_of_delivery" => $mode_of_delivery,
    "name_of_courier" => $name_of_courier,
    "pod_no" => $pod_no,
    "dispatch_date" => $dispatch_date,
];

use:

$columns = [

    "delivery_status" =>
        $delivery_status,

    "delivery_date" =>
        $delivery_date,

    "status" =>
        2,

    "mode_of_delivery" =>
        $mode_of_delivery,

    "name_of_courier" =>
        $name_of_courier,

    "pod_no" =>
        $pod_no,

    "dispatch_date" =>
        $dispatch_date
];


/*
 * Add Transit fields only
 * when a new Transit file was uploaded
 */
if ($file_names !== '') {

    $columns['delivery_proof'] =
        $file_names;

    $columns['file_name'] =
        $file_names;

    $columns['file_org_name'] =
        $file_org_names;
}


/*
 * Add POD fields only
 * when POD was uploaded
 */
if ($podfile_names !== '') {

    $columns['pod_proof'] =
        $podfile_names;

    $columns['podfile_org_name'] =
        $podfile_org_names;
}

Do the same for:

$columns_new

Use:

$columns_new = [

    "dispatch_delivery_status" =>
        $delivery_status,

    "delivery_date" =>
        $delivery_date,

    "mode_of_delivery" =>
        $mode_of_delivery,

    "name_of_courier" =>
        $name_of_courier,

    "pod_no" =>
        $pod_no,

    "status" =>
        2
];


if ($file_names !== '') {

    $columns_new[
        'delivery_proof'
    ] = $file_names;
}


if ($podfile_names !== '') {

    $columns_new[
        'pod_proof'
    ] = $podfile_names;
}
Step 7 — Change deleivery_pod

Find:

case 'deleivery_pod':

Remove this:

$parts = explode('/', $dc_no);

$po_num_value = end($parts);

$podfile =
    $_FILES['podfile']['name'];

$podextension =
    pathinfo(
        $_FILES['podfile']['name'],
        PATHINFO_EXTENSION
    );

$podtem_name =
    $po_num_value
    . "-POD."
    . $podextension;


if (
    move_uploaded_file(
        $_FILES['podfile']['tmp_name'],
        '../../uploads/dispatch/'
        . $podtem_name
    )
) {

    $podfile_names =
        $podtem_name;

    $podfile_org_names =
        $_FILES['podfile']['name'];
}

Replace with:

$podfile_names = '';
$podfile_org_names = '';


/* =========================================================
   GET INVOICE DETAILS FROM CURRENT DISPATCH
   ========================================================= */

$dispatchMetaResult =
    $pdo->select(
        [
            'dispatch_list',
            [
                'invoice_no',
                'invoice_date',
                'po_date'
            ]
        ],
        "po_form_unique_id = '"
        . $po_form_unique_id
        . "'
         AND consignee_unique_id = '"
        . $consignee_unique_id
        . "'
         AND dc_number = '"
        . $dc_no
        . "'
         AND is_delete = 0"
    );


$meta_invoice_no = '';
$meta_invoice_date = '';
$meta_po_date = '';


if (
    $dispatchMetaResult->status
    &&
    !empty(
        $dispatchMetaResult->data
    )
) {

    $meta_invoice_no =
        $dispatchMetaResult
            ->data[0]['invoice_no']
        ?? '';


    $meta_invoice_date =
        $dispatchMetaResult
            ->data[0]['invoice_date']
        ?? '';


    $meta_po_date =
        $dispatchMetaResult
            ->data[0]['po_date']
        ?? '';
}


/* =========================================================
   POD UPLOAD
   ========================================================= */

if (
    isset($_FILES['podfile'])
    &&
    isset($_FILES['podfile']['error'])
    &&
    $_FILES['podfile']['error'] === UPLOAD_ERR_OK
    &&
    !empty($_FILES['podfile']['name'])
) {

    try {

        $uploadInfo =
            prepareAcademicUploadFolder(
                'dispatch',
                $meta_invoice_no,
                $meta_invoice_date,
                $meta_po_date
            );


        $targetDir =
            $uploadInfo[
                'directory'
            ];


        $safe_dc_no =
            getSafeDispatchNumber(
                $dc_no
            );


        $podextension =
            strtolower(
                pathinfo(
                    $_FILES['podfile']['name'],
                    PATHINFO_EXTENSION
                )
            );


        $allowedExts = [
            'pdf',
            'jpg',
            'jpeg',
            'png',
            'xls',
            'xlsx'
        ];


        if (
            !in_array(
                $podextension,
                $allowedExts,
                true
            )
        ) {

            throw new Exception(
                'Invalid POD file type.'
            );
        }


        $podtem_name =
            $safe_dc_no
            . '-POD.'
            . $podextension;


        $destination =
            $targetDir
            . $podtem_name;


        if (
            !move_uploaded_file(
                $_FILES['podfile']['tmp_name'],
                $destination
            )
        ) {

            throw new Exception(
                'POD file upload failed.'
            );
        }


        $podfile_names =
            $podtem_name;


        $podfile_org_names =
            $_FILES['podfile']['name'];


    } catch (Throwable $e) {

        echo json_encode([
            'status' => false,
            'msg' => 'error',
            'error' =>
                $e->getMessage()
        ]);

        exit;
    }
}

Your existing conditional DB update is good:

if (
    !empty($podfile_names)
    &&
    !empty($podfile_org_names)
) {

    $columns['pod_proof'] =
        $podfile_names;

    $columns['podfile_org_name'] =
        $podfile_org_names;
}

Keep that.

Step 8 — Replace Dispatch image_view()

Your current function assumes:

uploads/dispatch/file.pdf

But now the file may be:

uploads/dispatch/2026-2027/file.pdf

Replace the entire current image_view() with this:

function image_view(
    $folder_name = "",
    $unique_id = "",
    $delivery_proof = "",
    $invoice_no = "",
    $invoice_date = "",
    $po_date = ""
) {

    if (empty($delivery_proof)) {

        return '';
    }


    $file_names =
        explode(
            ',',
            $delivery_proof
        );


    $image_view = '';


    foreach (
        $file_names
        as $file_key => $file_name
    ) {

        $file_name =
            trim(
                $file_name
            );


        if ($file_name === '') {
            continue;
        }


        /*
         * Resolve:
         *
         * 2026-2027/file.pdf
         *
         * OR old:
         *
         * file.pdf
         */
        $relative_file =
            resolveAcademicFilePath(
                $folder_name,
                $file_name,
                $invoice_no,
                $invoice_date,
                $po_date
            );


        $extension =
            strtolower(
                pathinfo(
                    $relative_file,
                    PATHINFO_EXTENSION
                )
            );


        if ($file_key != 0) {

            if ($file_key % 4 != 0) {

                $image_view .=
                    '&nbsp;';

            } else {

                $image_view .=
                    '<br><br>';
            }
        }


        $image_view .=
            '<div class="text-center">';


        /* =================================================
           IMAGE
           ================================================= */

        if (
            in_array(
                $extension,
                [
                    'jpg',
                    'jpeg',
                    'png'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print_view(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/'
                . $folder_name
                . '/'
                . $relative_file
                . '"
                        height="20px"
                        width="20px"
                    >

                </a>';


        /* =================================================
           PDF
           ================================================= */

        } elseif (
            $extension === 'pdf'
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/pdf.png"
                        height="20px"
                        width="20px"
                    >

                </a>';


        /* =================================================
           EXCEL
           ================================================= */

        } elseif (
            in_array(
                $extension,
                [
                    'xls',
                    'xlsx'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/excel.png"
                        height="20px"
                        width="20px"
                    >

                </a>';


        /* =================================================
           WORD
           ================================================= */

        } elseif (
            in_array(
                $extension,
                [
                    'txt',
                    'doc',
                    'docx'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/word.png"
                        height="20px"
                        width="20px"
                    >

                </a>';
        }


        $image_view .=
            '</div>';
    }


    return $image_view;
}
Step 9 — Replace image_view1() for Invoice documents

Your Delivery datatable also shows:

DC file
IR file
Invoice file

coming from invoice_sublist.

Since your Invoice module also uses academic-year folders, replace image_view1() with:

function image_view1(
    $folder_name = "",
    $unique_id = "",
    $delivery_proof = "",
    $invoice_no = "",
    $invoice_date = "",
    $po_date = ""
) {

    if (empty($delivery_proof)) {

        return '';
    }


    $relative_file =
        resolveAcademicFilePath(
            'invoice',
            $delivery_proof,
            $invoice_no,
            $invoice_date,
            $po_date
        );


    $extension =
        strtolower(
            pathinfo(
                $relative_file,
                PATHINFO_EXTENSION
            )
        );


    /* =====================================================
       IMAGE
       ===================================================== */

    if (
        in_array(
            $extension,
            [
                'jpg',
                'jpeg',
                'png'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print_view1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/'
            . $relative_file
            . '"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    /* =====================================================
       PDF
       ===================================================== */

    if ($extension === 'pdf') {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/pdf.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    /* =====================================================
       EXCEL
       ===================================================== */

    if (
        in_array(
            $extension,
            [
                'xls',
                'xlsx'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/excel.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    /* =====================================================
       WORD
       ===================================================== */

    if (
        in_array(
            $extension,
            [
                'txt',
                'doc',
                'docx'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/word.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    return '';
}
Step 10 — Change fixed_datatable

Find:

foreach ($res_array as $key => $value) {

Immediately after that add:

/*
 * Keep RAW values before changing
 * values to HTML for DataTable
 */

$raw_invoice_no =
    $value['invoice_no']
    ?? '';

$raw_invoice_date =
    $value['invoice_date']
    ?? '';

$raw_po_date =
    $value['po_date']
    ?? '';

$raw_dc_number =
    $value['dc_number']
    ?? '';

Then find:

$value['einvoice'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['einvoice']
    );

Replace with:

$value['einvoice'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['einvoice'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );
Step 11 — Change deleivery_datatable

At the beginning of:

foreach ($res_array as $key => $value) {

add:

/*
 * Save RAW database values
 * BEFORE converting them to HTML.
 */

$raw_invoice_no =
    $value['invoice_no']
    ?? '';

$raw_invoice_date =
    $value['invoice_date']
    ?? '';

$raw_po_date =
    $value['po_date']
    ?? '';

$raw_dc_number =
    $value['dc_number']
    ?? '';

Then replace:

$value['delivery_proof'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['delivery_proof']
    );

with:

$value['delivery_proof'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['delivery_proof'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );

Replace:

$value['pod_proof'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['pod_proof']
    );

with:

$value['pod_proof'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['pod_proof'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );

Replace:

$value['einvoice'] =
    image_view(
        "dispatch",
        $value['dc_number'],
        $value['einvoice']
    );

with:

$value['einvoice'] =
    image_view(
        "dispatch",
        $value['unique_id'],
        $value['einvoice'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );
Step 12 — Change Invoice file calls inside Delivery

Replace:

$value['dc_file'] =
    image_view1(
        "invoice",
        $value['dc_number'],
        $value['dc_file']
    );

with:

$value['dc_file'] =
    image_view1(
        "invoice",
        $value['unique_id'],
        $value['dc_file'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );

Replace:

$value['ir_file_org_name'] =
    image_view1(
        "invoice",
        $value['dc_number'],
        $value['ir_file_org_name']
    );

with:

$value['ir_file_org_name'] =
    image_view1(
        "invoice",
        $value['unique_id'],
        $value['ir_file_org_name'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );

Replace:

$value['invoice_file_org_name'] =
    image_view1(
        "invoice",
        $value['dc_number'],
        $value['invoice_file_org_name']
    );

with:

$value['invoice_file_org_name'] =
    image_view1(
        "invoice",
        $value['unique_id'],
        $value['invoice_file_org_name'],
        $raw_invoice_no,
        $raw_invoice_date,
        $raw_po_date
    );
Step 13 — Change your JS print functions

Replace your existing:

function print(file_name) {
    ...
}

function print_view(file_name) {
    ...
}

function print1(file_name) {
    ...
}

function print_view1(file_name) {
    ...
}

with:

function cleanUploadFilePath(file_name) {

    if (!file_name) {
        return '';
    }

    return String(file_name)
        .replace(/\\/g, '/')
        .replace(/^\/+/, '');
}


/* =========================================================
   DISPATCH PDF / FILE
   ========================================================= */

function print(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/dispatch/' + file_name,
        'dispatch_file',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   DISPATCH IMAGE
   ========================================================= */

function print_view(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/dispatch/' + file_name,
        'dispatch_image',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   INVOICE PDF / FILE
   ========================================================= */

function print1(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/invoice/' + file_name,
        'invoice_file',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   INVOICE IMAGE
   ========================================================= */

function print_view1(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/invoice/' + file_name,
        'invoice_image',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}
Step 14 — Your form page

For the initial Dispatch Save page, no change is required.

You already have:

<input
    type="hidden"
    name="invoice_no"
    id="invoice_no"
    value="<?php echo $invoice_no; ?>"
>

and your AJAX already sends:

data.append(
    "invoice_no",
    invoice_no
);

So PHP already receives the invoice number required for academic-year detection.

Step 15 — Existing old files

Suppose your database already contains:

DC Number:
CHN/DC/2525

Invoice Number:
CHN/25-26/3120

einvoice_file:
2525-Dispatch.pdf

You can manually move the old file to:

/var/www/html/otm_beta/uploads/dispatch/
+-- 2025-2026/
    +-- 2525-Dispatch.pdf

You do not have to modify the database filename.

Our resolveAcademicFilePath() does:

invoice_no
CHN/25-26/3120
        ?
2025-2026
        ?
check:
uploads/dispatch/2025-2026/2525-Dispatch.pdf

If it exists, it opens it.

Step 16 — Future new files

For a new record:

DC:
CHN/DC/2525

Invoice:
CHN/26-27/3312

PHP automatically creates:

uploads/dispatch/2026-2027/

and saves:

CHN-DC-2525-Dispatch.pdf

Database:

einvoice_file

CHN-DC-2525-Dispatch.pdf

Physical file:

/var/www/html/otm_beta/uploads/dispatch/
2026-2027/
CHN-DC-2525-Dispatch.pdf

Transit:

CHN-DC-2525-Transit.pdf

POD:

CHN-DC-2525-POD.pdf
Step 17 — Same DC next year is safe
2025-2026
DC:
CHN/DC/2525

Invoice:
CHN/25-26/3120

Stored:

uploads/dispatch/
+-- 2025-2026/
    +-- CHN-DC-2525-Dispatch.pdf
2026-2027
DC:
CHN/DC/2525

Invoice:
CHN/26-27/3312

Stored:

uploads/dispatch/
+-- 2026-2027/
    +-- CHN-DC-2525-Dispatch.pdf

So no overwrite.

Step 18 — Folder permission

On your server, ensure PHP can create folders:

sudo chown -R www-data:www-data /var/www/html/otm_beta/uploads/dispatch

Then:

sudo chmod -R 775 /var/www/html/otm_beta/uploads/dispatch

After that PHP can automatically create:

2027-2028
2028-2029
2029-2030

when those years start.

One small issue I also noticed in your current CRUD: you assign $action_obj_1 but later check $action_obj1. That variable name mismatch should also be corrected, although it is separate from the file overwrite issue.
