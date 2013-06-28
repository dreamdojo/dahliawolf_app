<<<<<<< HEAD
<?
/*
// Update image created dates with old_post time_added
UPDATE image
	INNER JOIN old_posts ON image.pid = old_posts.PID
SET image.created = FROM_UNIXTIME(old_posts.time_added)

// Propogate image.created to posting.created for affected rows (image.pid IS NOT NULL)
UPDATE posting
INNER JOIN image ON posting.image_id = image.id
SET posting.created = image.created
WHERE image.pid IS NOT NULL
=======
<?
/*
// Update image created dates with old_post time_added
UPDATE image
	INNER JOIN old_posts ON image.pid = old_posts.PID
SET image.created = FROM_UNIXTIME(old_posts.time_added)

// Propogate image.created to posting.created for affected rows (image.pid IS NOT NULL)
UPDATE posting
INNER JOIN image ON posting.image_id = image.id
SET posting.created = image.created
WHERE image.pid IS NOT NULL
>>>>>>> 5edbe6c9174c69dcc5e6287ce151d3df30e4799d
*/