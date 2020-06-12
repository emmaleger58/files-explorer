<?php     function formatSizeUnits($bytes)
      {
          if ($bytes >= 1073741824)
          {
              $bytes = number_format($bytes / 1073741824, 2) . ' GB';
          }
          elseif ($bytes >= 1048576)
          {
              $bytes = number_format($bytes / 1048576, 2) . ' MB';
          }
          elseif ($bytes >= 1024)
          {
              $bytes = number_format($bytes / 1024, 2) . ' KB';
          }
          elseif ($bytes > 1)
          {
              $bytes = $bytes . ' octets';
          }
          elseif ($bytes == 1)
          {
              $bytes = $bytes . ' octet';
          }
          else
          {
              $bytes = '0 octet';
          }

          return $bytes;
        } //fonction pour convertir bytes en kb
