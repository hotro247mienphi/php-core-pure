<?php
/**
 * GHI CHÚ:
 * - Tên thư mục nên đặt có nghĩa, mô tả nội dung mà nó chứa đựng. Ví dụ, thư mục chứa các file cấu hình thì nên đặt tên là: configs, settings...
 * - Tên file thường thì nên đặt tên là chữ in thường, phân cách nhau bằng dấu gạch dưới ( file_with_long_name.php ).
 * - Tên file là Class thì nên đặt tên trùng với tên class ( class Application => file: Application.php ).
 * - Tên hàm riêng lẻ thì sử dụng kiểu snake_case ( function_name() ).
 * - Tên hàm (phương thức) trong class thì sử dụng kiểu camelCase ( functionName() ).
 * - Tên hàm cần nói lên được chức năng mà nó thực hiện. Ví dụ, hàm lấy ngày giờ hiện tại thì nên đặt tên là: getCurrentDateTime(), get_current_datetime()..
 * - Tên biến thì sử dụng kiểu camelCase ( $variableName ).
 * - Tên biến (property) trong class kiểu private thì sử dụng dấu gạch dưới (prefix underscore) ở trước ( private $_instance ).
 * - Tên key trong mảng nên đặt theo dạng snake_case.
 *   Ví dụ:
 *      $persons = [
 *          'year_of_birth' => 1990,
 *          'current_job'=>'developer',
 *      ];
 * - Tên cũng nên được đặt để người đọc có thể phân biệt được dữ liệu chứa là số ít hay số nhiều.
 *   Ví dụ:
 *      $number = 1;            // số ít
 *      $numbers = [1,2,3,4,5]  // số nhiều
 */

define('TABLE_PET', 'pets');
define('TABLE_EVENT', 'events');
define('TABLE_CUSTOMER', 'customers');

/**
 * -------------------------------------------------------------------------------------
 * Nhóm hàm cấp 1
 * được xây dựng để sử dụng chung cho một số task vụ, có thể tùy biến tham số
 * để thực hiện các task khác nhau.
 * -------------------------------------------------------------------------------------
 */

if (!function_exists('dump')) {
    /**
     * @param mixed ...$rest
     */
    function dump(...$rest)
    {
        echo '<pre>';
        var_dump(...$rest);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    /**
     * @param mixed ...$rest
     */
    function dd(...$rest)
    {
        dump(...$rest);
        die;
    }
}

if (!function_exists('random_date')) {
    /**
     * @return string
     */
    function random_date()
    {
        $year = get_item_random_in_array(range(2000, 2019));
        $month = get_item_random_in_array(range(1, 12));
        $date = get_item_random_in_array(range(1, date('t', strtotime($year . '-' . $month))));
        return sprintf('%s-%s-%s', $year, $month, $date);
    }

}

if (!function_exists('get_item_random_in_array')) {
    /**
     * @param $arr
     * @return mixed
     */
    function get_item_random_in_array($arr)
    {
        return $arr[array_rand($arr)];
    }
}

if (!function_exists('get_item_in_array')) {
    /**
     * @param array $arr
     * @param string $key
     * @param null $default
     * @return mixed
     */
    function get_item_in_array($arr = [], $key = '', $default = null)
    {
        return array_key_exists($key, $arr) ? $arr[$key] : $default;
    }
}

// TODO: nhóm liên quan tới mysql
if (!function_exists('mysql_execute')) {
    /**
     * @param $sql
     * @return bool|PDOStatement
     */
    function mysql_execute($sql)
    {
        global $instance;
        $stmt = $instance->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
}

if (!function_exists('drop_table')) {
    /**
     * @param $table
     */
    function drop_table($table)
    {
        mysql_execute("DROP TABLE IF EXISTS {$table};");
    }

}

if (!function_exists('truncate_table')) {
    /**
     * @param $table
     */
    function truncate_table($table)
    {
        mysql_execute("TRUNCATE {$table};");
    }

}

if (!function_exists('seeder_to_table')) {
    /**
     * @param $table
     * @param $data
     */
    function seeder_to_table($table, $data)
    {
        $valuesInsert = [];

        foreach ($data as $record):
            $fields = [];
            foreach ($record as $key => $val):
                if (null === $val) {
                    $fields[] = 'null';
                } else {
                    $fields[] = "'{$val}'";
                }

            endforeach;
            $valuesInsert[] = '(' . join(',', $fields) . ')';
        endforeach;

        $sql = sprintf(
            'INSERT INTO %s(%s) VALUES %s %s',
            $table,
            join(',', array_keys($data[0])),
            PHP_EOL,
            join(',' . PHP_EOL, $valuesInsert)
        );

        mysql_execute($sql);
    }

}

if (!function_exists('sql_fetch')) {
    /**
     * @param string $sql
     * @return bool|PDOStatement
     */
    function sql_fetch($sql = '')
    {
        $stmt = mysql_execute($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;
    }

}

if (!function_exists('sql_fetch_all')) {
    /**
     * @param string $sql
     * @return array
     */
    function sql_fetch_all($sql = '')
    {
        $stmt = sql_fetch($sql);
        return $stmt->fetchAll();
    }

}

if (!function_exists('sql_fetch_one')) {
    /**
     * @param string $sql
     * @return array
     */
    function sql_fetch_one($sql = '')
    {
        $stmt = sql_fetch($sql);
        return $stmt->fetch();
    }

}

if (!function_exists('sql_select')) {
    /**
     * @param string $table
     * @param string $columns
     * @param string $where
     * @return array
     */
    function sql_select($table = '', $columns = '*', $where = '1')
    {
        $sql = sprintf('SELECT %s FROM %s WHERE %s', $columns, $table, $where);
        $stmt = sql_fetch($sql);
        return $stmt->fetchAll();
    }

}

/**
 * -------------------------------------------------------------------------------------
 * Nhóm hàm cấp 2
 * thực hiện những công việc cụ thể, chi tiết cho một mục đích nào đó
 * -------------------------------------------------------------------------------------
 */

// TODO: nhóm khởi tạo table
if (!function_exists('create_pet_table')) {
    /**
     * create_pet_table
     */
    function create_pet_table()
    {

        drop_table(TABLE_PET);

        $sql = '
           CREATE TABLE `' . TABLE_PET . '` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(20) NOT NULL,
          `owner` VARCHAR(20) NOT NULL,
          `species` VARCHAR(20) NOT NULL,
          `sex` CHAR(1) DEFAULT NULL ,
          `birth` DATE DEFAULT NULL,
          `death` DATE DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ';

        mysql_execute($sql);
    }

}

if (!function_exists('create_event_table')) {
    /**
     * create_event_table
     */
    function create_event_table()
    {

        drop_table(TABLE_EVENT);

        $sql = '
           CREATE TABLE `' . TABLE_EVENT . '` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(20) NOT NULL,
          `date` DATE DEFAULT NULL,
          `type` VARCHAR(15) NOT NULL,
          `remark` VARCHAR(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ';

        mysql_execute($sql);
    }

}

if (!function_exists('create_customer_table')) {
    /**
     * create_event_table
     */
    function create_customer_table()
    {
        drop_table(TABLE_CUSTOMER);

        $sql = '
           CREATE TABLE `' . TABLE_CUSTOMER . '` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(255) NOT NULL,
          `job` VARCHAR(255) NOT NULL,
          `address` VARCHAR(255) NOT NULL,
          `s_name` VARCHAR(255) NOT NULL,
          `s_job` VARCHAR(255) NOT NULL,
          `s_address` VARCHAR(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ';

        mysql_execute($sql);
    }

}

if (!function_exists('migrate')) {
    /**
     * create_event_table
     */
    function migrate()
    {

        create_pet_table();
        create_event_table();
        create_customer_table();

        seeder_to_table(TABLE_PET, generate_data_seeding_pet_table());
        seeder_to_table(TABLE_EVENT, generate_data_seeding_event_table());
        seeder_to_table(TABLE_CUSTOMER, generate_data_seeding_customer_table());

    }

}

// TODO: nhóm hàm tạo dữ liệu mẫu
if (!function_exists('generate_data_seeding_pet_table')) {
    /**
     * @return array
     */
    function generate_data_seeding_pet_table()
    {
        return [
            [
                'name' => 'Fluffy',
                'owner' => 'Harold',
                'species' => 'cat',
                'sex' => 'f',
                'birth' => '1993-02-04',
                'death' => NULL
            ], [
                'name' => 'Claws',
                'owner' => 'Gwen',
                'species' => 'cat',
                'sex' => 'm',
                'birth' => '1994-03-17',
                'death' => null
            ], [
                'name' => 'Buffy',
                'owner' => 'Harold',
                'species' => 'dog',
                'sex' => 'f',
                'birth' => '1989-05-13',
                'death' => null
            ],
            [
                'name' => 'Fang',
                'owner' => 'Benny',
                'species' => 'dog',
                'sex' => 'm',
                'birth' => '1990-08-27',
                'death' => null
            ], [
                'name' => 'Bowser',
                'owner' => 'Diane',
                'species' => 'dog',
                'sex' => 'm',
                'birth' => '1979-08-31',
                'death' => '1995-07-29'
            ], [
                'name' => 'Chirpy',
                'owner' => 'Gwen',
                'species' => 'bird',
                'sex' => 'f',
                'birth' => '1998-09-11',
                'death' => null
            ], [
                'name' => 'Whistler',
                'owner' => 'Gwen',
                'species' => 'bird',
                'sex' => null,
                'birth' => '1997-12-09',
                'death' => null
            ], [
                'name' => 'Slim',
                'owner' => 'Benny',
                'species' => 'snake',
                'sex' => 'f',
                'birth' => '1996-04-29',
                'death' => null
            ],
        ];

    }

}

if (!function_exists('generate_data_seeding_event_table')) {
    /**
     * @return array
     */
    function generate_data_seeding_event_table()
    {
        return [
            [
                'name' => 'Fluffy',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => '4 kittens, 3 female, 1 male'
            ], [
                'name' => 'Buffy',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => '5 puppies, 2 female, 3 male'
            ], [
                'name' => 'Buffy',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => '3 puppies, 3 female'
            ], [
                'name' => 'Chirpy',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => 'needed beak straightened'
            ], [
                'name' => 'Slim',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => 'broken rib'
            ], [
                'name' => 'Bowser',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => ''
            ], [
                'name' => 'Fang',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => ''
            ], [
                'name' => 'Fang',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => 'Gave him a new chew toy'
            ], [
                'name' => 'Claws',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => 'Gave him a new flea collar'
            ], [
                'name' => 'Whistler',
                'date' => '1995-05-15',
                'type' => 'litter',
                'remark' => 'First birthday'
            ],
        ];
    }

}

if (!function_exists('generate_data_seeding_customer_table')) {
    /**
     * @return array
     */
    function generate_data_seeding_customer_table()
    {
        return [
            [
                'name' => 'Nguyễn Đức Thuận',
                'job' => 'backend developer',
                'address' => 'Ngõ 4, Đồng Me, Mễ Trì Thượng, Nam Từ Liêm, Hà Nội',
                's_name' => 'nguyen duc thuan',
                's_job' => 'backend developer',
                's_address' => 'Ngo 4, dong me, me tri thuong, nam tu liem, ha noi',
            ], [
                'name' => 'Triệu Thị Huyền Trang',
                'job' => 'quản trị nội dung',
                'address' => 'thôn Giáp Thượng, xã Đức Bác, huyện Sông Lô, tỉnh Vĩnh Phúc',
                's_name' => 'trieu thi huyen trang',
                's_job' => 'quan tri noi dung',
                's_address' => 'thon giap thuong, xa duc bac, huyen song lo, tinh vinh phuc',
            ],

        ];
    }
}

if (!function_exists('pd_connect_database')) {
    /**
     * @return PDO
     */
    function pdo_connect_database()
    {
        $dbConfigs = [
            'host' => 'localhost',
            'name' => 'test',
            'charset' => 'utf8mb4',
            'user' => 'root',
            'pass' => '',
        ];

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $dbConfigs['host'],
            $dbConfigs['name'],
            $dbConfigs['charset']
        );

        $instance = new \PDO($dsn, $dbConfigs['user'], $dbConfigs['pass']);

        $instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $instance;

    }
}

// TODO: nhóm hàm xử lý chuỗi
if (!function_exists('str_slug')) {
    /**
     * @param $title
     * @param string $separator
     * @param string $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        $title = $language ? str_ascii($title, $language) : $title;

        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';

        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

        // Replace @ with the word 'at'
        $title = str_replace('@', $separator . 'at' . $separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', str_lower($title));

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

        return trim($title, $separator);
    }
}

if (!function_exists('str_ascii')) {
    /**
     * @param $value
     * @param string $language
     * @return string|string[]|null
     */
    function str_ascii($value, $language = 'en')
    {
        $languageSpecific = str_language_specific_chars_array($language);

        if (!is_null($languageSpecific)) {
            $value = str_replace($languageSpecific[0], $languageSpecific[1], $value);
        }

        foreach (str_chars_array() as $key => $val) {
            $value = str_replace($val, $key, $value);
        }

        return preg_replace('/[^\x20-\x7E]/u', '', $value);
    }
}

if (!function_exists('str_language_specific_chars_array')) {
    /**
     * @param $language
     * @return mixed|null
     */
    function str_language_specific_chars_array($language)
    {
        static $languageSpecific;

        if (!isset($languageSpecific)) {
            $languageSpecific = [
                'bg' => [
                    ['х', 'Х', 'щ', 'Щ', 'ъ', 'Ъ', 'ь', 'Ь'],
                    ['h', 'H', 'sht', 'SHT', 'a', 'А', 'y', 'Y'],
                ],
                'da' => [
                    ['æ', 'ø', 'å', 'Æ', 'Ø', 'Å'],
                    ['ae', 'oe', 'aa', 'Ae', 'Oe', 'Aa'],
                ],
                'de' => [
                    ['ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü'],
                    ['ae', 'oe', 'ue', 'AE', 'OE', 'UE'],
                ],
                'ro' => [
                    ['ă', 'â', 'î', 'ș', 'ț', 'Ă', 'Â', 'Î', 'Ș', 'Ț'],
                    ['a', 'a', 'i', 's', 't', 'A', 'A', 'I', 'S', 'T'],
                ],
            ];
        }

        return $languageSpecific[$language] ?? null;
    }
}

if (!function_exists('str_chars_array')) {
    /**
     * @return array
     */
    function str_chars_array()
    {
        static $charsArray;

        if (isset($charsArray)) {
            return $charsArray;
        }

        return $charsArray = [
            '0' => ['°', '₀', '۰', '０'],
            '1' => ['¹', '₁', '۱', '１'],
            '2' => ['²', '₂', '۲', '２'],
            '3' => ['³', '₃', '۳', '３'],
            '4' => ['⁴', '₄', '۴', '٤', '４'],
            '5' => ['⁵', '₅', '۵', '٥', '５'],
            '6' => ['⁶', '₆', '۶', '٦', '６'],
            '7' => ['⁷', '₇', '۷', '７'],
            '8' => ['⁸', '₈', '۸', '８'],
            '9' => ['⁹', '₉', '۹', '９'],
            'a' => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'],
            'b' => ['б', 'β', 'ب', 'ဗ', 'ბ', 'ｂ'],
            'c' => ['ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'],
            'd' => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'],
            'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'],
            'f' => ['ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'],
            'g' => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'],
            'h' => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'],
            'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'],
            'j' => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'],
            'k' => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'],
            'l' => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'],
            'm' => ['м', 'μ', 'م', 'မ', 'მ', 'ｍ'],
            'n' => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'],
            'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'],
            'p' => ['п', 'π', 'ပ', 'პ', 'پ', 'ｐ'],
            'q' => ['ყ', 'ｑ'],
            'r' => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'],
            's' => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'],
            't' => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'],
            'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'],
            'v' => ['в', 'ვ', 'ϐ', 'ｖ'],
            'w' => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'],
            'x' => ['χ', 'ξ', 'ｘ'],
            'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'],
            'z' => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'],
            'aa' => ['ع', 'आ', 'آ'],
            'ae' => ['æ', 'ǽ'],
            'ai' => ['ऐ'],
            'ch' => ['ч', 'ჩ', 'ჭ', 'چ'],
            'dj' => ['ђ', 'đ'],
            'dz' => ['џ', 'ძ'],
            'ei' => ['ऍ'],
            'gh' => ['غ', 'ღ'],
            'ii' => ['ई'],
            'ij' => ['ĳ'],
            'kh' => ['х', 'خ', 'ხ'],
            'lj' => ['љ'],
            'nj' => ['њ'],
            'oe' => ['ö', 'œ', 'ؤ'],
            'oi' => ['ऑ'],
            'oii' => ['ऒ'],
            'ps' => ['ψ'],
            'sh' => ['ш', 'შ', 'ش'],
            'shch' => ['щ'],
            'ss' => ['ß'],
            'sx' => ['ŝ'],
            'th' => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
            'ts' => ['ц', 'ც', 'წ'],
            'ue' => ['ü'],
            'uu' => ['ऊ'],
            'ya' => ['я'],
            'yu' => ['ю'],
            'zh' => ['ж', 'ჟ', 'ژ'],
            '(c)' => ['©'],
            'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'],
            'B' => ['Б', 'Β', 'ब', 'Ｂ'],
            'C' => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'],
            'D' => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'],
            'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'],
            'F' => ['Ф', 'Φ', 'Ｆ'],
            'G' => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'],
            'H' => ['Η', 'Ή', 'Ħ', 'Ｈ'],
            'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'],
            'J' => ['Ｊ'],
            'K' => ['К', 'Κ', 'Ｋ'],
            'L' => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'],
            'M' => ['М', 'Μ', 'Ｍ'],
            'N' => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'],
            'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'],
            'P' => ['П', 'Π', 'Ｐ'],
            'Q' => ['Ｑ'],
            'R' => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'],
            'S' => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'],
            'T' => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'],
            'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'],
            'V' => ['В', 'Ｖ'],
            'W' => ['Ω', 'Ώ', 'Ŵ', 'Ｗ'],
            'X' => ['Χ', 'Ξ', 'Ｘ'],
            'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'],
            'Z' => ['Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'],
            'AE' => ['Æ', 'Ǽ'],
            'Ch' => ['Ч'],
            'Dj' => ['Ђ'],
            'Dz' => ['Џ'],
            'Gx' => ['Ĝ'],
            'Hx' => ['Ĥ'],
            'Ij' => ['Ĳ'],
            'Jx' => ['Ĵ'],
            'Kh' => ['Х'],
            'Lj' => ['Љ'],
            'Nj' => ['Њ'],
            'Oe' => ['Œ'],
            'Ps' => ['Ψ'],
            'Sh' => ['Ш'],
            'Shch' => ['Щ'],
            'Ss' => ['ẞ'],
            'Th' => ['Þ'],
            'Ts' => ['Ц'],
            'Ya' => ['Я'],
            'Yu' => ['Ю'],
            'Zh' => ['Ж'],
            ' ' => ["\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80", "\xEF\xBE\xA0"],
        ];
    }
}

if (!function_exists('str_lower')) {
    /**
     * @param $value
     * @return false|mixed|string|string[]|null
     */
    function str_lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }
}

/**
 * -------------------------------------------------------------------------------------
 * code chạy trực tiếp
 * -------------------------------------------------------------------------------------
 */

try {

    $instance = pdo_connect_database();

    $data = sql_select(TABLE_CUSTOMER, 'id, name, job, address');

    header('content-type: application-json');

    echo json_encode($data);

} catch (\PDOException $e) {

    dump($e->getMessage());
}
