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
}

abstract class DatabaseConfig
{
    const host = 'localhost';
    const username = 'root';
    const password = '';
    const databaseName = 'db_college_notifier';
}
