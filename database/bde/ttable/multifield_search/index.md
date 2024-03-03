---
Title: Поиск по нескольким полям
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Поиск по нескольким полям
=========================

    keyfields:='name;name_1;n_dom;n_kw';
    keyvalues:=VarArrayOf([combobox1.Text, combobox2.Text, edit2.Text, edit3.text]);
    if dmod.qrfiz.Locate(keyfields,keyvalues,[])=false then
      dmod.qrfiz.Locate('id',id1,[]);

