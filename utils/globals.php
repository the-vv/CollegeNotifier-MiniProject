<?php
abstract class UserTypes
{
    const student = 'student';
    const faculty = 'faculty';
    const parent = 'parent';
    const admin = 'admin';
}

abstract class eventTypes
{
    const event = 'event';
    const notification = 'notification';
}

abstract class CookieNames
{
    const admin = 'admin_user';
    const parent = 'parent_user';
    const faculty = 'faculty_user';
    const student = 'student_user';
}

abstract class TableNames
{
    const admin = 'tbl_admin';
    const batch = 'tbl_batches';
    const classes = 'tbl_classes';
    const college = 'tbl_college';
    const department = 'tbl_department';
    const event = 'tbl_event';
    const faculty = 'tbl_faculty';
    const parents = 'tbl_parents';
    const participants = 'tbl_participants';
    const room_student_map = 'tbl_room_student_map';
    const rooms = 'tbl_rooms';
    const students = 'tbl_students';
    const forms = 'tbl_forms';
    const form_submissions = 'tbl_form_submissions';
}

abstract class DatabaseConfig
{
    const host = 'localhost';
    const username = 'root';
    const password = '';
    const databaseName = 'db_college_notifier';
}

abstract class HashingConfig
{
    const hashing_iv = '1234567891011121';
    const hashing_key = 'VVsCollegeNotifier';
}

abstract class LevelTypes
{
    const college = 'college';
    const department = 'department';
    const batch = 'batch';
    const classes = 'class';
    const room = 'room';
}

abstract class FeatureConfigurations {
    const allow_multiple_colleges = false;
    const send_event_create_emails = true;
    const production_mode = true;    
}

abstract class ApiKeysConfig {
    const send_grid_api_key = 'REMOVED';
}