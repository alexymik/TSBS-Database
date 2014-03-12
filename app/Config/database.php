<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Database configuration class.
 *
 * You can specify multiple configurations for production, development and testing.
 *
 * datasource => The name of a supported datasource; valid options are as follows:
 *  Database/Mysql - MySQL 4 & 5,
 *  Database/Sqlite - SQLite (PHP5 only),
 *  Database/Postgres - PostgreSQL 7 and higher,
 *  Database/Sqlserver - Microsoft SQL Server 2005 and higher
 *
 * You can add custom database datasources (or override existing datasources) by adding the
 * appropriate file to app/Model/Datasource/Database. Datasources should be named 'MyDatasource.php',
 *
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * host =>
 * the host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database. This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres/Sqlserver specifies which schema you would like to use the tables in.
 * Postgres defaults to 'public'. For Sqlserver, it defaults to empty and use
 * the connected user's default schema (typically 'dbo').
 *
 * encoding =>
 * For MySQL, Postgres specifies the character encoding to use when connecting to the
 * database. Uses database default not specified.
 *
 * unix_socket =>
 * For MySQL to connect via socket specify the `unix_socket` parameter instead of `host` and `port`
 *
 * settings =>
 * Array of key/value pairs, on connection it executes SET statements for each pair
 * For MySQL : http://dev.mysql.com/doc/refman/5.6/en/set-statement.html
 * For Postgres : http://www.postgresql.org/docs/9.2/static/sql-set.html
 * For Sql Server : http://msdn.microsoft.com/en-us/library/ms190356.aspx
 */
class DATABASE_CONFIG {

	public $default = array(
        'datasource' => 'Database/Sqlite',
        'persistent' => false,
        'database' => 'sqlite_db',
        'prefix' => '',
        'encoding' => 'utf8',
	);
}


//Database Setup Info

/*
TECHNICAL SERVICE BULLETINS  

The SERVICE BULLETIN file contains manufacturer technical notices received 
by NHTSA since January 1, 1995.

File characteristics:

-  All the records are TAB delimited.
-  All dates are in YYYYMMDD format

-  Maximum Record length: 710

Change log:
1. Changed flat file extension from .lst to .txt as of Sept. 14, 2007
2. Field 1 was changed from CHAR(12) to CHAR(16) on Aug. 22, 2008
3. Field 2 was changed from CHAR(12) to CHAR(16) on Sep. 18, 2008

Last Updated September 18, 2008

FIELDS:
=======

Field#   Name                Type/Size   Description
---      ----------          ----------  -------------------------------------
1        BULNO               CHAR(16)    SERVICE BULLETIN NUMBER
2        BULREP              CHAR(16)    REPLACEMENT SERVICE BULLETIN NUMBER
3        ID                  NUMBER(9)   NHTSA ITEM NUMBER
4        BULDTE              CHAR(8)     DATE OF BULLETIN
5        COMPNAME            CHAR(128)   CODE FOR FAILING COMPONENT
6        MAKETXT             CHAR(25)    VEHICLE/EQUIPMENT MAKE
7        MODELTXT            CHAR(256)   VEHICLE/EQUIPMENT MODEL
8        YEARTXT             CHAR(4)     MODEL YEAR, 9999 IF UNKNOWN or N/A
9        DATEA               CHAR(8)     DATE ADDED TO FILE
10       SUMMARY             CHAR(240)   DESCRIPTION OF SUMMARY
 
.timer on

CREATE TABLE tsbs (
	BUL_NO CHAR(16),
	BUL_REP CHAR(16),
	NHTSA_ID INT(9),
	BUL_DATE CHAR(8),
	COMPONENT CHAR(128),
	MAKE CHAR(128),
	MODEL CHAR(256),
	YEAR INT(4),
	DATEADDED CHAR(8),
	SUMMARY CHAR(240)
);

.separator "	"
.import FLAT_TSBS.txt tsbs

CREATE TABLE bulletins (
	ID INTEGER PRIMARY KEY AUTOINCREMENT,
	BUL_NO CHAR(16),
	BUL_REP CHAR(16),
	NHTSA_ID INT(9),
	BUL_DATE CHAR(8),
	COMPONENT CHAR(128),
	MAKE CHAR(128),
	MODEL CHAR(256),
	YEAR INT(4),
	DATEADDED CHAR(8),
	SUMMARY CHAR(240)
);

INSERT INTO bulletins(BUL_NO, BUL_REP, NHTSA_ID, BUL_DATE, COMPONENT, MAKE, MODEL, YEAR, DATEADDED, SUMMARY) SELECT * FROM tsbs;

CREATE TABLE vehicles (
	ID INTEGER PRIMARY KEY AUTOINCREMENT,
	MAKE CHAR(128),
	MODEL CHAR(256),
	YEAR INT(4)
);

INSERT INTO vehicles(MAKE, MODEL, YEAR) SELECT MAKE, MODEL, YEAR FROM tsbs GROUP BY MODEL, YEAR;

CREATE TABLE vehicles_bulletins (
	ID INTEGER PRIMARY KEY AUTOINCREMENT,
	VEHICLE_ID INTEGER NOT NULL,
	BULLETIN_ID INTEGER NOT NULL
)

DROP TABLE tsbs;

CREATE INDEX makes_index ON bulletins (MAKE);
CREATE INDEX models_index ON bulletins (MODEL);
CREATE INDEX buldate_index ON bulletins (BUL_DATE);

*/