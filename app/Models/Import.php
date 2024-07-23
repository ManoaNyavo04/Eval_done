<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Import extends Model
{
    use HasFactory;

    public function createFunctionVerification(){
        DB::statement('
            CREATE OR REPLACE FUNCTION get_interval_between(
                timestamp1 TIMESTAMP,
                timestamp2 TIMESTAMP
            )
            RETURNS INTERVAL
            AS $$
            DECLARE
                result_interval INTERVAL;
            BEGIN
                result_interval := timestamp2 - timestamp1;
                RETURN result_interval;
            END;
            $$ LANGUAGE plpgsql;

        ');

        DB::statement('
            CREATE OR REPLACE FUNCTION cast_valid_date(date_text VARCHAR)
                RETURNS DATE
                AS $$
                DECLARE
                    formatted_date_text VARCHAR;
                    result_date DATE;
                BEGIN
                    formatted_date_text := REPLACE(date_text, '/', '-');
                BEGIN
                    result_date := TO_DATE(formatted_date_text, \'DD-MM-YYYY\');
                    EXCEPTION
                        WHEN others THEN
                            RETURN NULL;
                    END;
                    RETURN result_date;
                END;
                $$ LANGUAGE plpgsql;
        ');

        DB::statement('
            CREATE OR REPLACE FUNCTION cast_valid_datetime(date_text VARCHAR)
            RETURNS TIMESTAMP
            AS $$
            DECLARE
                result_date TIMESTAMP;
            BEGIN
                BEGIN
                    result_date := TO_TIMESTAMP(date_text, \'DD/MM/YYYY HH24:MI:SS\');
                EXCEPTION
                    WHEN others THEN
                        RETURN NULL;
                END;
                RETURN result_date;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::statement('
            CREATE OR REPLACE FUNCTION is_numeric(num TEXT)
            RETURNS BOOLEAN
            AS $$
            BEGIN
                IF num ~ \'^-?\\d*\\.?\\d+$\' THEN
                    RETURN TRUE;
                ELSE
                    RETURN FALSE;
                END IF;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::statement('
            CREATE OR REPLACE FUNCTION is_numeric_and_positive(num TEXT)
            RETURNS BOOLEAN
            AS $$
            BEGIN
                IF num ~ \'^-?\\d*\\.?\\d+$\' THEN
                    IF num::NUMERIC > 0 THEN
                        RETURN TRUE;
                    ELSE
                        RETURN FALSE;
                    END IF;
                ELSE
                    RETURN FALSE;
                END IF;
            END;
            $$ LANGUAGE plpgsql;
        ');


    }

    public function verify_etape(){
        
    }
}
