/*
  В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT),
  таблица с тегами tags (id INTEGER, name TEXT)
  и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)).
  Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
 */

SELECT id, name
FROM goods JOIN goods_tags ON goods.id = goods_tags.goods_id
GROUP BY id, name
HAVING COUNT(DISTINCT goods_tags.tag_id) == (SELECT COUNT(id) FROM tags);


/*
 Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины,
 и все они (каждый) поставили высокую оценку (строго выше 5).
 */

SELECT department_id
FROM evaluations
WHERE gender == true
GROUP BY department_id
HAVING MIN(value) >= 5;
