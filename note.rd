SELECT rd.id,  df.name,df.level, rd.defect_id, df.cate_id, (SELECT name FROM defect_categories WHERE df.cate_id = id) AS cate_defect_name, rd.defect_quantity, rd.note, rd.create_at FROM report_defect as rd JOIN defects as df ON df.id = rd.defect_id WHERE rd.report_id = 2 AND defect_id = 1 AND level LIKE '%Nặng%' AND cate_id = 1 ORDER BY cate_defect_name DESC




http://localhost/KimDuc/radix/admin/%3Cbr%20/%3E%3Cb%3EWarning%3C/b%3E:%20%20Undefined%20variable%20$defectIdAdd%20in%20%3Cb%3EE:/program%20File/xampp/htdocs/KimDuc/radix/admin/modules/reports/edit.php%3C/b%3E%20on%20line%20%3Cb%3E926%3C/b%3E%3Cbr%20/%3Ehttp://localhost/KimDuc/radix/admin/?module=reports&action=edit&report_defect_note_add=&cate_defect_id_add=1&id=1