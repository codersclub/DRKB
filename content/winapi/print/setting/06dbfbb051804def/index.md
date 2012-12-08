---
Title: Метрики принтера
Date: 01.01.2007
---

Метрики принтера
================

::: {.date}
01.01.2007
:::

При печати с помощью TPrinter могу ли я определить момент, когда
достигнут конец листа? Возможно ли получить высоту базовой строки с
назначенным шрифтом?

Font.Height дает вам высоту шрифта в пикселях с учетом интервала.

Как мне преобразовать высоту в пикселях в дюймы печатаемой страницы?

Не делайте этого, используйте у TPrinter свойства PageHeight и
PageWidth.

Хорошо, но я еще что - то не учел.Например, я использую шрифт Courier
New размером 9 точек:

Printer.Canvas.Font.Height = -12

Printer.PageHeight = 3150

Даже отбрасывая загадку унарного минуса, я получаю 3150 div 12, или 262
строк на страницу.

Посмотри электронную справку по теме \'Printer.Canvas.TextHeight\'.Это
свойство покажет вам, какую высоту будет использовать \'текущий
шрифт\'.Это то, что вы должны использовать для определения \'количество
строк на странице\'.Например, шрифт Courier New размером 9 точек имеет
значение TextHeight, равное 40. Поделите 3150 на эту величину и вы
получите 78 \'строк\', почти правильную величину для 9 - точечного
шрифта, если принимать во внимание то, что на дюйме помещается примерно
8 строк.

Для определения количества точек на дюйм(как горизонтально, так и
вертикально)можно использовать API функцию GetDeviceCaps.Полученные
значения позволят вам правильно преобразовать пиксели в дюймы.

Значение - 12 для 9 - точечного шрифта Courier - это высота шрифта для
устройства с разрешением 96 DPI(например, ваш экран).Попробуйте
назначить величину 9 свойству Size после того как вы вызвали BeginDoc и
посмотрите на значение свойства Height.Это должно быть значительно
большей величиной.

Вызывая команду Printer.NewPage, вы \_не\_ начинаете печать очередной
строки, а заставляете принтер закончить печать на текущем листе и начать
печать сверху нового листа(кажется, принтер HPLJ IIIP понимает эту
команду иначе).После вызова Printer.NewPage следующая строка печатается
примерно в полдюйме от верха бумаги.

Кроме того, приведу здесь текст моей текущей программы для печати текста
компонента Memo с заголовком на каждой странице:

    procedure btPrintMemoWithHeader(Memo: TCustomMemo;
      Printer: TPrinter;
      PrintDialog: TPrintDialog;
      HeaderText: string;
      TopMargin, BottomMargin, LeftMargin: Integer);
    var
      FirstPage: Boolean;
      i, LinesPerPage, CurrentLine, Line: Integer;
      PrintText: System.Text;
      LeftMarginString, Header: string;
    begin
      if PrintDialog.Execute then
        begin
          with Printer do
            begin
              AssignPrn(PrintText);
              Rewrite(PrintText);
    {Заполняем левую часть строки определенным количеством пробелов.}
              LeftMarginString := '';
              for i := 0 to LeftMargin do
                LeftMarginString := LeftMarginString + ' ';
    {Назначаем принтеру такой же шрифт, как и в компоненте Memo.:\}
              Canvas.Font := (Memo as TMemo).Font;
    {Вычисляем количество строк на странице.}
              LinesPerPage := PageHeight div Canvas.TextHeight('X');
              LinesPerPage := LinesPerPage - 8 - TopMargin - BottomMargin;
              CurrentLine := LinesPerPage;
              FirstPage := True;
    {Печать Memo.}
              for Line := 0 to Memo.Lines.Count - 1 do
                begin
    {Если конец страницы, начинаем новую.}
                  if CurrentLine >= LinesPerPage then
                    begin
    {Печатаем "Form Feed", если это не новая страница принтера.}
                      if not FirstPage then Write(PrintText, #12); {Если не первая страница, то меняем лист}
                      FirstPage := False;
    {Печатаем определенное количество пустых строк для верхнего поля.}
                      for i := 0 to TopMargin do
                        Writeln(PrintText, '');
    {Форматируем и печатаем строку заголовока.}
                      Header := Format('Страница %s     %s  %s     %s'#13#10,
                        [IntToStr(Printer.PageNumber), DateToStr(Date),
                        TimeToStr(Time), HeaderText]);
                      Write(PrintText, LeftMarginString);
                      Writeln(PrintText, Header);
    {Сбрасываем номер текущей строки на 1 для следующей страницы.}
                      CurrentLine := 1;
                    end;
    {Печатаем строку из Memo.}
                  Write(PrintText, LeftMarginString);
                  Writeln(PrintText, Memo.Lines[Line]);
                  Inc(CurrentLine);
                end;
              CloseFile(PrintText);
            end;
        end;
    end;

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
