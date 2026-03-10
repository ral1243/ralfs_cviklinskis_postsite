BEGIN if image_updated = 1
AND edit_id = (
    SELECT account_id
    from posts
    WHERE id = post_id
) then
UPDATE posts
SET title = title1,
    price = price1,
    DESCRIPTION = DESCRIPTION1,
    image = image1,
    tags_id = tags_id1
WHERE id = post_id;
ELSE
UPDATE posts
SET title = title1,
    price = price1,
    DESCRIPTION = DESCRIPTION1,
    tags_id = tags_id1
WHERE id = post_id;
END if;
RETURN("afragr");
END