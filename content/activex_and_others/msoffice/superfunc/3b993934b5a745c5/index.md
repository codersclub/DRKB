---
Title: Рисунки и другие объекты MS Word
Date: 01.01.2007
---


Рисунки и другие объекты MS Word
================================

::: {.date}
01.01.2007
:::

Используя доступ к Word.Application из приложений Delphi, можно
вставлять в текст документа записи, рисунки и другие объекты. Сложные
документы в формате Word обычно могут содержать не только таблицы или
текст, но также записи, линии и фигуры, объекты WordArt, рисунки,
графику и многое другое.

Все эти объекты можно разделить на две группы: те, которые являются
внутренними объектами Word, и внешние объекты, создаваемые внешними по
отношению к самому Word серверами OLE. Все объекты, рассмотренные в 1-4
части статьи, - это внутренние объекты.

Кто программирует в Visual Basic в среде Word и в Delphi, тот может
дальше сам развивать тему \"Суперфункций\". Все просто. Объекты,
коллекции и методы, которые работают в среде Word, переносятся почти без
изменений в среду Delphi. Главное здесь - применить немного
изобретательности и находчивости. Можно использовать палитру компонентов
Servers, которая есть в Delphi, начиная с 5-й версии. Выбор между
готовыми компонентами и работой \"напрямую\" с Word.Application зависит
от профессионализма, сложности поставленных задач, отпущенного времени и
главное - от вкусов и стиля программирования. Это индивидуально для
каждого, кто занимается разработкой сложных и не очень сложных
приложений на Delphi и других языках программирования. Я свой выбор
остановил на работе с Word.Application, так как это дает больше гибкости
и возможностей при решении сложных и нестандартных задач

Рассмотрим еще несколько необходимых внутренних и использование
некоторых внешних объектов, их создание и управление из приложений на
Delphi.

Одним из часто используемых объектов является Textbox. Для его создания
используем коллекцию Shapes(формы) и ее метод AddTextbox. Объект
коллекции Shapes имеет атрибут - имя, его можно считать, можно изменить
и обращаться к объекту не только через индекс, но и через имя. В функцию
создания объекта Textbox передаем в качестве аргументов координаты и
размеры области, а возвращаем имя объекта. Она выглядит следующим
образом.

    Function CreateTextBox (Left,Top,Width,Height:real;
      var name:string):boolean;
     const msoTextOrientationHorizontal=1;
    begin
     CreateTextBox:=true;
     try
      name:=W.ActiveDocument.Shapes.AddTextbox
      (msoTextOrientationHorizontal,Left,Top,Width,Height).Name;
     except
      CreateTextBox:=false;
     end;
    End;

 

Следующей естественной задачей является запись текста в TextBox.
Используем доступ к созданному объекту (Shapes.Item) через индекс(число)
или имя(строка). Текст можно записать в свойство Text объекта TextRange.
Перед записью текста проверяем тип формы (Shape). Если форма имеет тип
TextRange, тогда записываем текст. Смотрите реализацию в виде функции
TextToTextBox на Delphi.

    Function TextToTextBox (TextBox:variant;text: string):boolean;
     const msoTextBox=17;
    begin
     TextToTextBox:=true;
     try
      if w.ActiveDocument.Shapes.Item(TextBox).Type = msoTextBox then
       W.ActiveDocument.Shapes.Item(TextBox).TextFrame.TextRange.Text:=Text
      else TextToTextBox:=false;
     except
      TextToTextBox:=false;
     end;
    End;

 

Объект - форма (Shape) - может иметь тип не только как запись, он может
содержать картинку, звук, линию и др. В зависимости от типа формы,
процедура ее создания различна, но некоторые поля не зависят от типа.
Одним из таких полей является имя формы, которое можно получить или
изменить. Создадим две функции для определения имени (индекса) формы и
для его изменения.

    Function GetNameIndexShape (NameShape:variant): variant;
    begin
     try
      GetNameIndexShape:=W.ActiveDocument.Shapes.Item(NameShape).Name;
     except
      GetNameIndexShape:=false;
     end;
    End;

В качестве аргумента этой функции можно использовать как индекс, так и
имя формы.

    Function SetNewNameShape (NameShape:variant;
      NewNameShape:string):string;
    begin
     try
      W.ActiveDocument.Shapes.Item(NameShape).Name:=NewNameShape;
      SetNewNameShape:=NewNameShape;
     except
      SetNewNameShape:='';
     end;
    End;

Здесь можно было бы рассмотреть реализацию функций перемещения,
изменения размеров, а также определение положения и размеров формы в
документе. Можете сделать это самостоятельно. В Visual Basic для этого
используются следующие операторы:

ActiveDocument.Shapes.Item (NameShape).Left = Left

ActiveDocument.Shapes.Item (NameShape).Top = Top

ActiveDocument.Shapes.Item (NameShape).Width = Width

ActiveDocument.Shapes.Item (NameShape).Height = Height

Или наоборот

Left = ActiveDocument.Shapes.Item (NameShape).Left

Top = ActiveDocument.Shapes.Item (NameShape).Top

Width = ActiveDocument.Shapes.Item (NameShape).Width

Height = ActiveDocument.Shapes. Item(NameShape).Height

В документах часто могут использоваться рисованные объекты, например,
линии. Для их создания также используем коллекцию Shapes (формы) и ее
метод AddTextbox. В функцию создания объекта Line передаем в качестве
аргументов начальные и конечные координаты линии, а возвращаем имя
объекта. Эта функция выглядит следующим образом:

    Function CreateLine (BeginX,BeginY,EndX,EndY: real;
      var name:string):boolean;
    begin
     CreateLine:=true;
     try
      name:=W.ActiveDocument.Shapes.AddLine(BeginX,BeginY,EndX,EndY).Name;
     except
      CreateLine:=false;
     end;
    End;

Для прорисовки сложной фигуры необходимо использовать метод AddPolyline
коллекции Shapes. Аргументом этой функции должен быть массив точек
(massiv). Реализация на Visual Basic имеет следующий вид:

ActiveDocument.Shapes.AddPolyline (massiv)

Для того, чтобы вставить рисунок из внешнего файла, необходимо
использовать метод AddPicture коллекции Shapes, а в качестве аргумента
имя файла и координаты. Создадим такую функцию.

    Function CreatePicture(FileName:string;Left,Top: real;
      var name:string):boolean;
    begin
     CreatePicture:=true;
     try
      name:=W.ActiveDocument.Shapes.AddPicture(FileName).Name;
      W.ActiveDocument.Shapes.Item (name).Left:=Left;
      W.ActiveDocument.Shapes.Item(name). Top:=Top;
     except
      CreatePicture:=false;
     end;
    End;

Мы должны иметь возможность не только создать новый объект, но и удалить
ранее созданный, например, рисунок или запись. Для этого используется
метод Delete коллекции Shapes. Для использования этого в своих
приложениях создадим функцию DeleteShape, в качестве аргумента которой
будет имя или индекс объекта Shape.

    Function DeleteShape (NameShape:variant): variant;
    Begin
     DeleteShape:=true;
     try
      W.ActiveDocument.Shapes.Item (NameShape).Delete;
     except
      DeleteShape:=false;
     end;
    End;

Внешний объект в документе представляет собой Ole-объект, отображаемый
внешней программой, которая является Ole-сервером по отношению к
редактору Word. Такими объектами могут быть рисунки (BMP), созданные
программой Paint или лист Excel. Внешний объект может отображаться в
документе только тогда, когда установлена поддерживающая его программа.
Для внедрения внешних объектов в документ используется метод
AddOLEObject коллекции Shapes. Например, чтобы получить доступ к объекту
в Visual Basic, используется следующий оператор:

Set obb = ActiveDocument.Shapes.AddOLEObject(\"MSGraph.Chart.8\")

В Delphi он выглядит следующим образом:

Var Obb:variant;

Obb:=W.ActiveDocument.Shapes.AddOLEObject(\"MSGraph.Chart.8\");

Где W - Word.Application.

Но чтобы программировать Ole-объект, необходимо знать его поля и методы.
Эта информация индивидуальна для каждого объекта и ее рассмотрение -
отдельная тема.

На основе созданных нами функций создадим небольшую демонстрационную
программу, которая будет создавать объект-запись и объект-линию, а затем
удалит их из документа. Как всегда, используем ранее созданные функции,
разместим на форме кнопку и процедуре обработки ее нажатия напишем
следующий программный текст:

    procedure TForm1.Button1Click (Sender: TObject);
     var BoxName_,LineName_:string;
    begin
     if CreateWord then begin
      Messagebox(0,'Word запущен.','',0);
      VisibleWord(true);
      Messagebox(0,'Word видим.','',0);
      If AddDoc then begin
       Messagebox(0,'Документ создан.','',0);
       CreateTextBox(1,1,100,50,BoxName_);
       Messagebox(0,'Создали форму - надпись.','',0);
       Messagebox(0,pchar(GetNameIndexShape(1)) ,
        'Считали имя формы',0);
       BoxName_:=SetNewNameShape(BoxName_,'Новое имя');
       Messagebox(0,pchar(GetNameIndexShape (1)),
        'Изменили имя формы и считываем его снова',0);
       TextToTextBox(BoxName_,'Добавляем текст в TextBox');
       Messagebox(0,'Рисуем линию','',0);
       CreateLine(1,15,300,200,LineName_);
       Messagebox(0,'Удаляем линию','',0);
       DeleteShape(LineName_);
       Messagebox(0,'Удаляем надпись','',0);
       DeleteShape(BoxName_);
       SaveDocAs('c:\Документ, содержащий объекты');
       Messagebox(0,'Текст сохранен','',0);
       CloseDoc;
      end;
      Messagebox(0,' Текст закрыт','',0);
      CloseWord;
     end;
    end;

 

В своей статье я постарался показать основы создания документов Word на
основе Word.Application и Delphi. На самом деле возможности здесь
таковы, что позволяют использовать редактор Word в качестве генератора
отчетов для создания документов любой сложности. Пожалуй, только
используя редактор Excel, их можно превзойти. Продолжение будет
посвящено программированию документов в Excel из приложений на Delphi.

По всем вопросам вы можете обратиться к автору по адресу
www.kornjakov.ru или \_kvn\@mail.ru. Исходный текст
www.kornjakov.ru/st1\_5.zip.

Василий КОРНЯКОВ

Литература: Н. Елманова, С. Трепалин, А.Тенцер \"Delphi 6 и технология
COM\" \"Питер\" 2002.
