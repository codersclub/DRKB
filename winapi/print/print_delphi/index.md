---
Title: Печать в Delphi
Date: 01.01.2007
Source: http://www.delphi.h5.ru/
---

Печать в Delphi
===============

Объект printer автоматически создается в случае, если в программе
указана ссылка на модуль printers. Этот объект предоставляет
программисту все необходимое для того, чтобы научить приложение выводить
данные на один из подключенных к компьютеру принтеров.

Вывод на принтер в windows ничем не отличается от вывода на экран: в
распоряжение программиста предоставляется свойство canvas объекта
printer, содержащее набор чертежных инструментов, и методы, свойственные
классу tcanvas. Размер листа бумаги в пикселах определяют свойства
height и width, а набор принтерных шрифтов - свойство fonts.

**Печать текста**

Существует множество способов печати текста на принтере. Прежде всего
следует назвать глобальную процедуру assignprn (она определена в модуле
printers), позволяющую использовать принтер как текстовый файл и
печатать текстовые строки с помощью процедуры writeln. В листинге 1
(printtext.dpr) приведен полный текст модуля, на форме которого
расположены многострочный текстовый редактор memo1 и четыре кнопки: для
выбора текстового файла и ввода его содержимого в редактор, для выбора
нужного шрифта отображения/печати документа, для инициации процесса
печати и для завершения работы программы.

**Листинг 1**

    unit unit1;
    
    interface 
     
    uses 
    windows, messages, sysutils, classes, graphics, controls, forms, dialogs, stdctrls, buttons; 
     
    type 
    tform1 = class(tform) 
      memo1: tmemo; 
      button1: tbutton; 
      button2: tbutton; 
      opendialog1: topendialog; 
      bitbtn1: tbitbtn; 
      button3: tbutton; 
      fontdialog1: tfontdialog; 
      procedure button1click(sender: tobject); 
      procedure button2click(sender: tobject); 
      procedure button3click(sender: tobject); 
      private 
      { private declarations } 
      public 
      { public declarations } 
    end; 
     
    var 
    form1: tform1; 
     
    implementation 
     
    uses printers; // Эта ссылка обязательна! 
     
    {$r *.dfm} 
     
    procedure tform1.button1click(sender: tobject); 
    // Выбор файла с текстом и его загрузка в редактор 
    begin 
    if opendialog1.execute then 
      memo1.lines.loadfromfile(opendialog1.filename) 
    end; 
     
    procedure tform1.button3click(sender: tobject); 
    // Выбор шрифта и связывание его с memo1 
    begin 
      if fontdialog1.execute then 
        memo1.font := fontdialog1.font 
    end; 
     
    procedure tform1.button2click(sender: tobject); 
    // Печать содержимого редактора как вывод в текстовый файл 
    var 
    prn: textfile; 
    k: integer; 
    begin 
      assignprn(prn); // Переназначаем вывод в файл на вывод в принтер 
      rewrite(prn); // Готовим принтер к печати (аналог begindoc) 
      { Для печати используем такой же шрифт, как и для показа 
      в редакторе: } 
      printer.canvas.font := memo1.font; 
      // Цикл печати: 
      for k := 0 to memo1.lines.count-1 do 
        writeln(prn, memo1.lines[k]); 
      closefile(prn); // Аналог enddoc 
    end; 
     
    end. 

Описанный способ печати - самый примитивный: с его помощью невозможно
вывести линии, разделяющие колонки или строки, трудно форматировать
текст, вставлять заголовки, номера страниц и т.д.

Значительно более гибкие средства обеспечивает свойство printer.canvas.
Покажем, как с его помощью можно напечатать текст, содержащийся в
редакторе memo1 (printtext.dpr, листинг 2):

**Листинг 2**

    procedure tform1.button2click(sender: tobject); 
    // Печать содержимого редактора c помощью свойства printer.canvas 
    var 
    y,dy,x,k: integer; 
    s: string; 
    begin 
      if memo1.lines.count=0 then exit; 
      screen.cursor := crhourglass; 
      with printer do 
      begin 
        begindoc; 
        with canvas do 
        begin 
          font := memo1.font; 
          dy := textheight('1'); // Определяем высоту строки 
          y := 3*dy; // Отступ от верхнего края листа 
          x := pagewidth div 15; // Отступ от левого края 
          for k := 0 to memo1.lines.count-1 do 
          begin 
            // Выводим очередную строку 
            textout(x,y,memo1.lines[k]); 
            // Смещаемся на следующую строку листа 
            inc(y,dy); 
            if pageheight-y<2*dy then // Нижний край листа? 
            begin // Да 
              newpage; // Переход на новый лист 
              // Выводим номер страницы посередине листа: 
              s := '- '+inttostr(pagenumber)+' -'; 
              textout((pagewidth-textwidth(s)) div 2, dy, s); 
              // и отчеркиваем его от текста: 
              moveto(x, 3*dy div 2); 
              lineto(pagewidth-x, 9*dy div 4); 
              // Ордината первой строки: 
              y := 3*dy 
            end; // if pageheight-y<2*dy 
          end; // for k := 0 to memo1.lines.count-1 do 
        end; // with canvas do 
        enddoc; 
      end; // with printer do 
      screen.cursor := crdefault; 
    end; 

Как можно увидеть, прямое обращение к чертежным инструментам свойства
canvas требует от программиста значительно больших усилий, но зато
предоставляет ему полный контроль над печатным изображением.

Во многих случаях для печати документа и внесения в него элементарных
средств форматирования (печать общего заголовка, заголовка на каждой
странице, номеров страниц и т.п.) проще использовать специальные
компоненты, расположенные на странице qreport палитры компонентов
delphi. Эти компоненты разработаны для создания отчетов по базам данных,
но могут с успехом использоваться и для печати обычных документов
(printtext.dpr).

Наконец, очень хороших результатов можно достичь, используя
специализированные средства просмотра/печати документов, как, например,
текстовый процессор ms word.

**Печать изображений**

Печать изображений может показаться очень сложным делом, однако свойство
printer.canvas содержит метод:

    procedure stretchdraw(const rect: trect; graphic: tgraphic);

который легко справляется с этой задачей. При обращении к нему в
качестве первого параметра указывается прямоугольная область, отводимая
на поверхности листа для распечатки изображения,
а в качестве второго - объект класса tgraphic,
в котором хранится изображение, например:

    with printer do 
    begin 
      begindoc; 
      canvas.stretchdraw(canvas.cliprect, image1.picture.graphic); 
      enddoc; 
    end; 

