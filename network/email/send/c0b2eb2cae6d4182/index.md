---
Title: Автозаполнение формы для нового письма
Author: Vit
Date: 01.01.2007
---


Автозаполнение формы для нового письма
======================================

::: {.date}
01.01.2007
:::

А вот пример автозаполнения формы для нового письма в почтовой программе
установленной по умолчанию:

    uses shellapi;
     

     
    ...
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    shellexecute(handle,
    'Open',
    'mailto:someone@somewhere.ru?subject=Regarding your advice&Body=First%20Line%0D%0ASecond%20line&CC=somebodyelse@somewhere.ru',
    nil, nil, sw_restore);
    end;

Немного пояснений:

1\) Пробелы в тексте желательно заполнять сочетанием %20

2\) Конец строки обозначать как %0D%0A

3\) Поля отделять друг от друга символом &

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
