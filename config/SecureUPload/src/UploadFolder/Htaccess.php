<?php

namespace Alirdn\SecureUPload\UploadFolder;

class Htaccess
{
    /**
     * @var string Allowed file types as string delimited by `|`
     */
    private $file_types_string = '';

    /**
     * @var string .htaccess main body (Apache 2.4 compatible)
     */
    private $htaccess_main_content = '
        IndexIgnore *
        Options -Indexes

        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteRule ^(php\.ini|\.htaccess) - [F,NC]
        </IfModule>

        # Deny execution of scripts
        <FilesMatch "\.(php|php[0-9]?|phtml|pl|py|jsp|asp|sh|cgi|js|html?|shtml)$">
            Require all denied
        </FilesMatch>
    ';

    /**
     * @var string Allowed file types section
     */
    private $htaccess_content_for_file_types = '
        <FilesMatch "\.(FILE_TYPES)$">
            Require all granted
        </FilesMatch>
    ';

    /**
     * Set allowed file types
     */
    public function setFileTypes($file_types_string = '')
    {
        $this->file_types_string = $file_types_string;
    }

    /**
     * Get final .htaccess content
     */
    public function getContent()
    {
        if (empty($this->file_types_string)) {
            $htaccess_content = $this->htaccess_main_content;
        } else {
            $htaccess_content =
                $this->htaccess_main_content .
                str_replace('FILE_TYPES', $this->file_types_string, $this->htaccess_content_for_file_types);
        }

        return trim(preg_replace('/\t+/', '', $htaccess_content));
    }
}
