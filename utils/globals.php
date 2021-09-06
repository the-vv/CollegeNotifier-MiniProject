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
}
