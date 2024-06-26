---
Title: Работа с MS Word из Delphi
Date: 01.01.2007
Author: 13 SoftWare
Source: www.vladimir13.narod.ru
---


Работа с MS Word из Delphi
==========================


Здесь мы рассмотрим пример того, как управлять объектами Word-а (Excel -
аналогично) из программ на Delphi.

а). Для чего это нужно ?

Задачи могут быть самые разные, в общем случае это использование
возможностей Word-а в своей программе, н-р: проверка текста на
орфографию; печать текста, графики; экспорт отчетов в Word или
изначальное создание их там и т.д.

б). Подготовительные работы. На самом деле существует несколько способов
сделать это, мы рассмотрим только один (пример кроме Delphi 5, в Delphi5
для этого есть компоненты на закладке Servers переименуете в программе
типы на соответствующие компоненты, дальше так же).

Для начала начнем новый проект File, New Application; File, Save All.
Создадим отдельную папку для проекта и сохраним Unit1 как Main, а
Project1 как WordWriter.

Далее для работы с Word-ом нам потребуется библиотека типов Word-а, это
делается так:

Project, Import Type Library, Add, далее переходим в папку, где стоит
Word ( у меня это - "c:\\program files\\microsoft office), заходим в
папку Office и выбираем файл - msword8.olb (цифра -? версии Word-а - у
Вас может отличаться ) или excel8.olb (для Excel).Нажимаем Оk. Delphi
создаст 2 файла - Word\_tlb.pas и Office\_tlb.pas, их надо включить в
раздел uses модуля Main нашего проекта:

    uses ...,Office_Tlb, word_tlb;

в). Теперь займемся непосредственно программированием.

В разделе var опишем следующие переменные:

    // класс приложения ворда
    WordApp:Word_tlb.Application_;
    // класс чего-то типа выделения,
    // т.е. говоришь - выделить ячейку с ... по, а результат скидываешь
    // в эту перем и работаешь с этими ячейками как с 1 объектом
    ARange,TempRange:Range;
    // массив документов
    Docs:documents;
    // 1 документ
    Doc:document;
    // массив параграфов
    pars:Paragraphs;
    // 1 параграф
    par:Paragraph;
    // параметры для передачи
    Template,temp,OpenAsTemplate:olevariant;
    // массив таблиц
    tabls:Tables;
    // 1 таблица
    tabl:Table;
    // рабочая переменная 
    i:integer;

Далее проектируем форму:

1. Поместим вверх нашей формы кнопку - button1 типа tbutton, поменяем
заголовок (свойство Caption) на \'Старт\'.

2. Под кнопкой разместим панель - panel1 типа tpanel. Внутри панели
поместим компонент - bevel1 типа tbevel, поменяем свойство Align на
alClient (при этом рамка растянется на всю панель).

3. Сверху панели (далее все компоненты будут размещаться внутри этой
панели) разместим метку - label1 типа tlabel, поменяем значение свойства
Caption на \'Передать в ячейку\':

4. Ниже слева поместим метку - label1 типа tlabel, свойство Caption
поменяем на \'X=\'

5. Правее метки помещаем компонент Edit1 типа tEdit, свойство Text меняем
на \'1\'

6. По правой границе Edit1 помещаем компонент UpDown1 типа tUpDown, в
списке свойства \'Associate\' выбираем Edit1, свойство \'Position\'
приравниваем \'1\'

7. Чуть отступаем вправо и повторяем шаги 4-6, заменив Edit1 на Edit2,
UpDown1 на UpDown2, Label1 на Label2 соответственно.

8. Ниже размещаем еще одну метку - label4 типа tlabel, меняем свойство
\'Caption\' на \'Новое значение ячейки:\'

9. Ниже размещаем компонент Edit3 типа tEdit, свойство Text меняем на \'0\'

10. И, наконец, в самом низу панели размещаем кнопку BitBtn1 типа
tBitBtn, меняем свойство \'Kind\' на \'bkOk\'.

Теперь напашем обработчики - именно в них и заключается вся
функциональность программы:

1). Назначим обработчик OnClick компоненту Button1 :

```
procedure TForm1.Button1Click(Sender: TObject);
begin
// если заголовок 'Выход', то закрываем программу
if button1.caption='Выход' then 
begin
Application.Terminate;
exit
end
// иначе (при первом начатии, когда у нас заголовок 'Старт') 
//переименовываем заголовок в 'Выход'
else button1.caption:='Выход';
 
panel1.Visible:=true;
// создаем экземпляр ворда
WordApp:=CoApplication_.Create;
// делаем его видимым
WordApp.Visible:=true;
// шаблон
template:='Normal';
// создать шаблон
OpenAsTemplate:=false;
// что-то типа оператора with, можно было и напрямую обратиться
Docs:=WordApp.Documents;
// добавляем документ
Doc:=Docs.Add(template,OpenAsTemplate);
 
// выделить все
ARange:=Doc.Range(EmptyParam,EmptyParam);
// массив параграфов
pars:=doc.Paragraphs;
// переменная - параметр
template:=arange;
// новый параграф
par:=pars.Add(template);
// цвет зеленный 
par.Range.Font.ColorIndex:=11;
// вставляем текст
par.Range.InsertBefore('Привет !!!');
// переменная - параметр
template:=par.Range;
// новый параграф, чтобы таблица не потерла текст
par:=pars.Add(template);
// цвет черный 
par.Range.Font.ColorIndex:=0;
// вставляем текст
par.Range.InsertBefore('Переключившись в программу, можно программно менять текст ячеек !');
// переменная - параметр
template:=par.Range;
// новый параграф, чтобы таблица не потерла текст
par:=pars.Add(template);
// выделяем параграф 
arange:=par.Range;
 
// шрифт - жирный
ARange.Font.Bold:=1;
// шрифт - рукописный
ARange.Font.Italic:=1;
// получить массив таблиц
tabls:=aRange.Tables;
// добавляем новую таблицу размером 5 на 5
tabl:=tabls.Add(arange,5,5);
// в цикле
for i:=1 to 5 do
// задаем значение ячеек
tabl.Cell(i,1).Range.Text:=inttostr(i);
 
end;
```

2). Зададим обработчик формы:

```
procedure TForm1.FormDestroy(Sender: TObject);
var
  // для параметров
  SaveChanges:olevariant; 
begin
  // если Word не закрыт
  if not VarIsEmpty(WordApp) then begin
    { а можно сохранить автоматом:
      // имя файла в оле
      template:='Имя.doc';
      // если не сохранен, то
      if doc.Saved=false then
        // сохраняем
        Doc.SaveAs(template, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam);
 
      короче, пишешь имя объекта, ставишь точку и нажимаешь
      'ctrl'+' ' и изучаешь существующие методы и свойства
    }
  //изменения не сохранять
  SaveChanges:=false;
  // то закрыть сначала документ 
  Doc.Close(SaveChanges,EmptyParam,EmptyParam);
  // а потом и ворд
  WordApp.Quit(SaveChanges,EmptyParam,EmptyParam)
end;
end;
```

3). Назначим обработчик OnClick компоненту Bitbtn1 :

```
procedure TForm1.BitBtn1Click(Sender: TObject);
begin
// в соотв ячейку ставим соотв значение, 
// а можно и наоборот - получать значение из ячейки в переменную
tabl.Cell(UpDown2.Position,UpDown1.Position).Range.Text:=Edit3.Text;
end;
```

4). В общем-то, это все ...

**Дополнительная информация:**

- Справка Word-а (по Visual Basic, по умолчанию она не ставится -
запустите заново Setup и поставьте в соотв. месте галочку)

Книги:

- Чарльз Калверт "Энциклопедия пользователя Delphi4" (издательство - DiaSoft)
- Марко Кэнту "Delphi4 для профессионалов" (издательство - Питер)

Если у Вас другая версия Word-а:

Параметры ф-ций могут отличаться - обратитесь к справке (см. выше) или
если у Вас версия Delphi 3 и выше, то используем универсальный метод -
пишешь имя объекта, ставишь точку (если нужно посмотреть список
параметров у функции, то после открывающей скобки нажимаешь
'ctrl' + 'пробел' и изучаешь существующие методы и свойства).

(c) 13 SoftWare.
