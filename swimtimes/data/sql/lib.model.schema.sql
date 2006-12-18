
-----------------------------------------------------------------------------
-- sw_swimmer
-----------------------------------------------------------------------------

DROP TABLE [sw_swimmer];


CREATE TABLE [sw_swimmer]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(255),
	[year] INTEGER,
	[team_id] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([team_id]) REFERENCES sw_team ([id])

-----------------------------------------------------------------------------
-- sw_meet
-----------------------------------------------------------------------------

DROP TABLE [sw_meet];


CREATE TABLE [sw_meet]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(255),
	[startdate] TIMESTAMP,
	[enddate] TIMESTAMP,
	[pool_id] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([pool_id]) REFERENCES sw_pool ([id])

-----------------------------------------------------------------------------
-- sw_time
-----------------------------------------------------------------------------

DROP TABLE [sw_time];


CREATE TABLE [sw_time]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[swimmer_id] INTEGER,
	[meet_id] INTEGER,
	[event_id] INTEGER,
	[time] DOUBLE,
	[place] INTEGER,
	[points] INTEGER,
	[lane] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([swimmer_id]) REFERENCES sw_swimmer ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([meet_id]) REFERENCES sw_meet ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([event_id]) REFERENCES sw_event ([id])

-----------------------------------------------------------------------------
-- sw_split
-----------------------------------------------------------------------------

DROP TABLE [sw_split];


CREATE TABLE [sw_split]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[time_id] INTEGER,
	[number] INTEGER,
	[duration] DOUBLE
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([time_id]) REFERENCES sw_time ([id])

-----------------------------------------------------------------------------
-- sw_pool
-----------------------------------------------------------------------------

DROP TABLE [sw_pool];


CREATE TABLE [sw_pool]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(255),
	[lat] DOUBLE,
	[lng] DOUBLE
);

-----------------------------------------------------------------------------
-- sw_team
-----------------------------------------------------------------------------

DROP TABLE [sw_team];


CREATE TABLE [sw_team]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(255),
	[shortname] VARCHAR(16)
);

-----------------------------------------------------------------------------
-- sw_event
-----------------------------------------------------------------------------

DROP TABLE [sw_event];


CREATE TABLE [sw_event]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(255),
	[distance] INTEGER,
	[splitAt] INTEGER
);
