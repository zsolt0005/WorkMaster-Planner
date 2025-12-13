<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | INSERT TRIGGER
        |--------------------------------------------------------------------------
        */
        DB::unprepared("
            CREATE TRIGGER events_after_insert
            AFTER INSERT ON events
            FOR EACH ROW
            BEGIN
                DECLARE tempid INT;

                SELECT IFNULL(MAX(change_order), 0) + 1 INTO tempid
                FROM changelog
                WHERE id_row = NEW.id;

                INSERT INTO changelog
                (action, id_row, table_name, column_name, old_value, new_value, id_changed_by, changed_at, change_order)
                VALUES
                    ('insert', NEW.id, 'events', 'created_by_user_id', NULL, NEW.created_by_user_id, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'event_type_id', NULL, NEW.event_type_id, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'assigned_user_id', NULL, NEW.assigned_user_id, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'title', NULL, NEW.title, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'description', NULL, NEW.description, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'start_date_time', NULL, NEW.start_date_time, NEW.created_by_user_id, NOW(), tempid),
                    ('insert', NEW.id, 'events', 'end_date_time', NULL, NEW.end_date_time, NEW.created_by_user_id, NOW(), tempid);
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER events_after_update
            AFTER UPDATE ON events
            FOR EACH ROW
            BEGIN
                DECLARE tempid INT;

                SELECT IFNULL(MAX(change_order), 0) + 1 INTO tempid
                FROM changelog
                WHERE id_row = NEW.id;

                IF NOT (OLD.created_by_user_id <=> NEW.created_by_user_id) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'created_by_user_id', OLD.created_by_user_id, NEW.created_by_user_id, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.event_type_id <=> NEW.event_type_id) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'event_type_id', OLD.event_type_id, NEW.event_type_id, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.assigned_user_id <=> NEW.assigned_user_id) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'assigned_user_id', OLD.assigned_user_id, NEW.assigned_user_id, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.title <=> NEW.title) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'title', OLD.title, NEW.title, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.description <=> NEW.description) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'description', OLD.description, NEW.description, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.start_date_time <=> NEW.start_date_time) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'start_date_time', OLD.start_date_time, NEW.start_date_time, @current_user_id, NOW(), tempid);
                END IF;

                IF NOT (OLD.end_date_time <=> NEW.end_date_time) THEN
                    INSERT INTO changelog VALUES (NULL, 'update', NEW.id, 'events', 'end_date_time', OLD.end_date_time, NEW.end_date_time, @current_user_id, NOW(), tempid);
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER events_after_delete
            AFTER DELETE ON events
            FOR EACH ROW
            BEGIN
                DECLARE tempid INT;

                SELECT IFNULL(MAX(change_order), 0) + 1 INTO tempid
                FROM changelog
                WHERE id_row = OLD.id;

                INSERT INTO changelog
                (action, id_row, table_name, column_name, old_value, new_value, id_changed_by, changed_at, change_order)
                VALUES ('delete', OLD.id, 'events', NULL, NULL, NULL, @current_user_id, NOW(), tempid);
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS events_after_insert;');
        DB::unprepared('DROP TRIGGER IF EXISTS events_after_update;');
        DB::unprepared('DROP TRIGGER IF EXISTS events_after_delete;');
    }
};
