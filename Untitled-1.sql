-- UPDATE public."user"
-- 	SET roles = to_jsonb(ARRAY[""])
-- 	WHERE id = 26;

-- UPDATE public."user"

UPDATE public."user"
	SET roles = '["ROLE_ADMIN"]'
	WHERE id = 28;