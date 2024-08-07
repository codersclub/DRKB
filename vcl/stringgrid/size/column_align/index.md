---
Title: Выравнивание колонок TStringGrid
Date: 01.01.2007
---


Выравнивание колонок TStringGrid
================================

Вариант 1:

Author: Kurt

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Организуйте обработчик события сетки OnDrawCell. Создайте код
обработчика подобный этому:

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; Col, Row: Longint;
      Rect: TRect; State: TGridDrawState);
    var
      Txt: array[0..255] of Char;
    begin
      StrPCopy(Txt, StringGrid1.Cells[Col, Row]);
      SetTextAlign(StringGrid1.Canvas.Handle,
        GetTextAlign(StringGrid1.Canvas.Handle)
        and not (TA_LEFT or TA_CENTER) or TA_RIGHT);
      ExtTextOut(StringGrid1.Canvas.Handle, Rect.Right - 2, Rect.Top + 2,
        ETO_CLIPPED or ETO_OPAQUE, @Rect, Txt, StrLen(Txt), nil);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Нижеприведенный код выравняет данные компонента по правому краю:

    procedure TForm1.StringGrid1DrawCell(Sender: TObject; Col, Row:
      Longint; Rect: TRect; State: TGridDrawState);
    var
      lRow, lCol: Longint;
    begin
      lRow := Row;
      lCol := Col;
      with Sender as TStringGrid, Canvas do
      begin
        if (gdSelected in State) then
        begin
          Brush.Color := clHighlight;
        end
        else if (gdFixed in State) then
        begin
          Brush.Color := FixedColor;
        end
        else
        begin
          Brush.Color := Color;
        end;
        FillRect(Rect);
        SetBkMode(Handle, TRANSPARENT);
        SetTextAlign(Handle, TA_RIGHT);
        TextOut(Rect.Right - 2, Rect.Top + 2, Cells[lCol, lRow]);
      end;
    end;

Хитрость заключается в установке выравнивания текста TA\_RIGHT,
позволяющей осуществлять вывод текста, начиная с правой стороны (от
правой границы). Не бойтесь, текст не будет напечатан задом наперед!

Вы наверное уже обратили внимание на объявление локальных переменных
lCol и lRow. На входе я присваиваю им значения параметров Col и Row
(имя, которое дало мне Delphi IDE). Дело в том, что объект TStringGrid
имеет свойства с именами Col и Row. Эти свойства будут доступны в теле
блока "with Sender as TStringGrid", но они не являются параметрами для
всех обявленных в шапке блока объектов ((речь идет об объекте Canvas, у
которого нет свойств с именами Col и Row - В.О.)).


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure WriteText(ACanvas: TCanvas; const ARect: TRect; DX, DY: Integer;
      const Text: string; Format: Word);
    var
      S: array[0..255] of Char;
      B, R: TRect;
    begin
      with ACanvas, ARect do
      begin
        case Format of
          DT_LEFT: ExtTextOut(Handle, Left + DX, Top + DY, ETO_OPAQUE or
            ETO_CLIPPED,
              @ARect, StrPCopy(S, Text), Length(Text), nil);
     
          DT_RIGHT: ExtTextOut(Handle, Right - TextWidth(Text) - 3, Top + DY,
              ETO_OPAQUE or ETO_CLIPPED, @ARect, StrPCopy(S, Text),
              Length(Text), nil);
     
          DT_CENTER: ExtTextOut(Handle, Left + (Right - Left - TextWidth(Text)) div
            2,
              Top + DY, ETO_OPAQUE or ETO_CLIPPED, @ARect,
              StrPCopy(S, Text), Length(Text), nil);
        end;
      end;
    end;
     
    procedure TBEFStringGrid.DrawCell(Col, Row: Longint; Rect: TRect; State:
      TGridDrawState);
    var
      procedure Display(const S: string; Alignment: TAlignment);
      const
        Formats: array[TAlignment] of Word = (DT_LEFT, DT_RIGHT, DT_CENTER);
      begin
        WriteText(Canvas, Rect, 2, 2, S, Formats[Alignment]);
      end;
    begin
      { здесь задаем аргументы Col и Row, и форматируем как угодно ячейки }
      case Row of
        0: { Центрирование заголовков колонок }
          if (Col < ColCount) then
            Display(Cells[Col, Row], taCenter)
          else
            { Все другие данные имеют правое центрирование }
            Display(Cells[Col, Row], taRight);
      end;
    end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Создайте ваш собственный метод drawcell на примере того, что приведен
ниже:

    procedure Tsearchfrm.Grid1DrawCell(Sender: TObject; Col, Row: Longint;
      Rect: TRect; State: TGridDrawState);
    var
      l_oldalign: word;
    begin
      if (row = 0) or (col < 2) then
        {устанавливаем заголовок в жирном начертании}
        grid1.canvas.font.style := grid1.canvas.font.style + [fsbold];
     
      if col <> 1 then
      begin
        l_oldalign := settextalign(grid1.canvas.handle, ta_right);
        {NB использует для рисования правую сторону квадрата}
        grid1.canvas.textrect(rect, rect.right - 2, Rect.top + 2, grid1.cells[col,
          row]);
        settextalign(grid1.canvas.handle, l_oldalign);
      end
      else
      begin
        grid1.canvas.textrect(rect, rect.left + 2, rect.top + 2, grid1.cells[col,
          row]);
      end;
     
      grid1.canvas.font.style := grid1.canvas.font.style - [fsbold];
    end; 


------------------------------------------------------------------------

Вариант 5:

Author: Pavel Stont, pavel_stont@mail.ru.

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    {
    Код компонента для Delphi на основе стандартного TStringGrid.
     
    Компонет позволяет переносить текст в TStringGrid.
     
    В качестве исходного текста был использован компонент TWrapGrid.
    Автор Luis J. de la Rosa.
    E-mail: delarosa@ix.netcom.com
    Вы свободны в использовании, распространении и улучшении кода.
    Пожалуйста шлите любые комментарии и пожелания на адрес delarosa@ix.netcom.com.
     
    Далее были внесены изменения в исходный код, а именно добавлены методы вывода
    текста:
    1. atLeft - Вывод текста по левой границе;
    2. atCenter - Вывод текста по центру ячейки (по горизонтали);
    3. atRight - Вывод текста по правой границе;
    4. atWrapTop - Вывод и перенос текста по словам относительно верхней границы
    ячейки;
    5. atWrapCenter - Вывод и перенос текста по словам относительно центра ячейки
    (по вертикали);
    6. atWrapBottom - Вывод и перенос текста по словам относительно нижней границы
    ячейки;
     
    Вносил изменения и тестировал в Delphi 3/4/5:
    Автор Pavel Stont.
    E-mail: pavel_stont@mail.ru.
    Никаких ограничений на использование, распростанение и улучшение кода не налогаются.
    Буду очень признателен, если о всех замеченных неполадках сообщите по e-mail.
     
    Для использования:
    Выберите в Delphi пункты меню 'Options' - 'Install Components'.
    Нажмите 'Add'.
    Найдите и выберите файл с именем 'NewStringGrid.pas'.
    Нажмите 'OK'.
    После этого вы увидете компонент во вкладке "Other" палитры компонентов
    Delphi.
    После этого вы можете использовать компонент вместо стандартного TStringGrid.
     
    Успехов!
     
    Несколько дополнительных замечаний по коду:
    1. Методы Create и DrawCell были перекрыты.
    2. Введены два новых свойства, а именно AlignText и AlignCaption соответсвенно методы
    выравнивания текста в ячейках данных (обычно - белого цвета) и в фиксированных ячейках
    (обычно - серого цвета).
    3. Свойство Center - центрация текста по горизонтали независимо от метода.
    }
     
    unit NewStringGrid;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Grids;
     
    type
     
      TAlignText = (atLeft, atCenter, atRight, atWrapTop, atWrapCenter,
        atWrapBottom);
     
    type
     
      TNewStringGrid = class(TStringGrid)
      private
        { Private declarations }
        FAlignText: TAlignText;
        FAlignCaption: TAlignText;
        FCenter: Boolean;
        procedure SetAlignText(Value: TAlignText);
        procedure SetAlignCaption(Value: TAlignText);
        procedure SetCenter(Value: Boolean);
      protected
        { Protected declarations }
        procedure DrawCell(ACol, ARow: Longint; ARect: TRect;
          AState: TGridDrawState); override;
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
        { Published declarations }
        property AlignText: TAlignText read FAlignText write SetAlignText;
        property AlignCaption: TAlignText read FAlignCaption write SetAlignCaption;
        property Center: Boolean read FCenter write SetCenter;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
     
      RegisterComponents('Other', [TNewStringGrid]);
    end;
     
    { TNewStringGrid }
     
    constructor TNewStringGrid.Create(AOwner: TComponent);
    begin
     
      { Создаем TStringGrid }
      inherited Create(AOwner);
      { Задаем начальные параметры компонента }
      AlignText := atLeft;
      AlignCaption := atCenter;
      Center := False;
      DefaultColWidth := 80;
      DefaultRowHeight := 18;
      Height := 100;
      Width := 408;
      { Заставляем компонент перерисовываться нашей процедурой
      по умолчанию DrawCell }
      DefaultDrawing := FALSE;
    end;
     
    { Процедура DrawCell осуществляет перенос текста в ячейке }
     
    procedure TNewStringGrid.DrawCell(ACol, ARow: Integer; ARect: TRect;
     
      AState: TGridDrawState);
    var
     
      CountI, { Счетчик }
      CountWord: Integer; { Счетчик }
      Sentence, { Выводимый текст }
      CurWord: string; { Текущее выводимое слово }
      SpacePos, { Позиция первого пробела }
      CurXDef, { X-координата 'курсора' по умолчанию }
      CurYDef, { Y-координата 'курсора' по умолчанию }
      CurX, { Х-координата 'курсора' }
      CurY: Integer; { Y-координата 'курсора' }
      EndOfSentence: Boolean; { Величина, указывающая на заполненность ячейки }
      Alig: TAlignText; { Тип выравнивания текста }
      ColPen: TColor; { Цвет карандаша по умолчанию }
      MassWord: array[0..255] of string;
      MassCurX, MassCurY: array[0..255] of Integer;
      LengthText: Integer; { Длина текущей строки }
      MassCurYDef: Integer;
      MeanCurY: Integer;
     
      procedure VisualCanvas;
      begin
        { Прорисовываем ячейку и придаем ей 3D-вид }
        with Canvas do
        begin
          { Запоминаем цвет пера для последующего вывода текста }
          ColPen := Pen.Color;
          if gdFixed in AState then
          begin
            Pen.Color := clWhite;
            MoveTo(ARect.Left, ARect.Top);
            LineTo(ARect.Left, ARect.Bottom);
            MoveTo(ARect.Left, ARect.Top);
            LineTo(ARect.Right, ARect.Top);
            Pen.Color := clBlack;
            MoveTo(ARect.Left, ARect.Bottom);
            LineTo(ARect.Right, ARect.Bottom);
            MoveTo(ARect.Right, ARect.Top);
            LineTo(ARect.Right, ARect.Bottom);
          end;
          { Восстанавливаем цвет пера }
          Pen.Color := ColPen;
        end;
      end;
     
      procedure VisualBox;
      begin
        { Инициализируем шрифт, чтобы он был управляющим шрифтом }
        Canvas.Font := Font;
        with Canvas do
        begin
          { Если это фиксированная ячейка, тогда используем фиксированный цвет }
          if gdFixed in AState then
          begin
            Pen.Color := FixedColor;
            Brush.Color := FixedColor;
          end
            { в противном случае используем нормальный цвет }
          else
          begin
            Pen.Color := Color;
            Brush.Color := Color;
          end;
          { Рисуем подложку цветом ячейки }
          Rectangle(ARect.Left, ARect.Top, ARect.Right, ARect.Bottom);
        end;
      end;
     
      procedure VisualText(Alig: TAlignText);
      begin
        case Alig of
          atLeft:
            begin
              with Canvas do
                { выводим текст }
                TextOut(CurX, CurY, Sentence);
              VisualCanvas;
            end;
          atRight:
            begin
              with Canvas do
                { выводим текст }
                TextOut(ARect.Right - TextWidth(Sentence) - 2, CurY, Sentence);
              VisualCanvas;
            end;
          atCenter:
            begin
              with Canvas do
                { выводим текст }
                TextOut(ARect.Left + ((ARect.Right - ARect.Left -
                  TextWidth(Sentence)) div 2), CurY, Sentence);
              VisualCanvas;
            end;
          atWrapTop:
            begin
              { для каждого слова ячейки }
              EndOfSentence := FALSE;
              CountI := 0;
              while CountI <= SpacePos do
              begin
                MassWord[CountI] := '';
                CountI := CountI + 1;
              end;
              CountI := 0;
              CountWord := CurY;
              while (not EndOfSentence) do
              begin
                { для получения следующего слова ищем пробел }
                SpacePos := Pos(' ', Sentence);
                if SpacePos > 0 then
                begin
                  { получаем текущее слово плюс пробел }
                  CurWord := Copy(Sentence, 0, SpacePos);
                  { получаем остальную часть предложения }
                  Sentence := Copy(Sentence, SpacePos + 1, Length(Sentence) -
                    SpacePos);
                end
                else
                begin
                  { это - последнее слово в предложении }
                  EndOfSentence := TRUE;
                  CurWord := Sentence;
                end;
                with Canvas do
                begin
                  { если текст выходит за границы ячейки }
                  LengthText := TextWidth(CurWord) + CurX + 2;
                  if LengthText > ARect.Right then
                  begin
                    { переносим на следующую строку }
                    CurY := CurY + TextHeight(CurWord);
                    CurX := CurXDef + 2;
                  end;
                  if CountWord <> CurY then
                    CountI := CountI + 1;
                  MassWord[CountI] := MassWord[CountI] + CurWord;
                  { увеличиваем X-координату курсора }
                  CurX := CurX + TextWidth(CurWord);
                  CountWord := CurY;
                end;
              end;
              with Canvas do
              begin
                CountWord := 0;
                CurY := CurYDef + 2;
                CurX := CurXDef + 2;
                while CountWord <= CountI do
                begin
                  case Center of
                    True:
                      begin
                        CurWord := MassWord[CountWord];
                        if Copy(CurWord, Length(CurWord) - 1, 1) = ' ' then
                          MassWord[CountWord] := Copy(CurWord, 0, Length(CurWord) -
                            1);
                        MassCurX[CountWord] := ARect.Left + ((ARect.Right -
                          ARect.Left - TextWidth(MassWord[CountWord])) div 2);
                        MassWord[CountWord] := CurWord;
                      end;
                    False: MassCurX[CountWord] := CurX;
                  end;
                  MassCurY[CountWord] := CurY;
                  { выводим слово }
                  TextOut(MassCurX[CountWord], MassCurY[CountWord],
                    MassWord[CountWord]);
                  CurY := CurY + TextHeight(MassWord[CountWord]);
                  CountWord := CountWord + 1;
                end;
              end;
              VisualCanvas;
            end;
          atWrapCenter:
            begin
              { для каждого слова ячейки }
              EndOfSentence := FALSE;
              CountI := 0;
              while CountI <= SpacePos do
              begin
                MassWord[CountI] := '';
                CountI := CountI + 1;
              end;
              CountI := 0;
              CountWord := CurY;
              while (not EndOfSentence) do
              begin
                { для получения следующего слова ищем пробел }
                SpacePos := Pos(' ', Sentence);
                if SpacePos > 0 then
                begin
                  { получаем текущее слово плюс пробел }
                  CurWord := Copy(Sentence, 0, SpacePos);
                  { получаем остальную часть предложения }
                  Sentence := Copy(Sentence, SpacePos + 1, Length(Sentence) -
                    SpacePos);
                end
                else
                begin
                  { это - последнее слово в предложении }
                  EndOfSentence := TRUE;
                  CurWord := Sentence;
                end;
                with Canvas do
                begin
                  { если текст выходит за границы ячейки }
                  LengthText := TextWidth(CurWord) + CurX + 2;
                  if LengthText > ARect.Right then
                  begin
                    { переносим на следующую строку }
                    CurY := CurY + TextHeight(CurWord);
                    CurX := CurXDef + 2;
                  end;
                  if CountWord <> CurY then
                    CountI := CountI + 1;
                  MassWord[CountI] := MassWord[CountI] + CurWord;
                  { увеличиваем X-координату курсора }
                  CurX := CurX + TextWidth(CurWord);
                  CountWord := CurY;
                end;
              end;
              with Canvas do
              begin
                CountWord := 0;
                CurX := CurXDef + 2;
                while CountWord <= CountI do
                begin
                  case Center of
                    True:
                      begin
                        CurWord := MassWord[CountWord];
                        if Copy(CurWord, Length(CurWord) - 1, 1) = ' ' then
                          MassWord[CountWord] := Copy(CurWord, 0, Length(CurWord) -
                            1);
                        MassCurX[CountWord] := ARect.Left + ((ARect.Right -
                          ARect.Left - TextWidth(MassWord[CountWord])) div 2);
                        MassWord[CountWord] := CurWord;
                      end;
                    False: MassCurX[CountWord] := CurX;
                  end;
                  MassCurY[CountWord] := TextHeight(MassWord[CountWord]);
                  CountWord := CountWord + 1;
                end;
                CountWord := 0;
                MassCurYDef := 0;
                while CountWord <= CountI do
                begin
                  MassCurYDef := MassCurYDef + MassCurY[CountWord];
                  CountWord := CountWord + 1;
                end;
                MassCurYDef := (ARect.Bottom - ARect.Top - MassCurYDef) div 2;
                CountWord := 0;
                MeanCurY := 0;
                while CountWord <= CountI do
                begin
                  MassCurY[CountWord] := ARect.Top + MeanCurY + MassCurYDef;
                  MeanCurY := MeanCurY + TextHeight(MassWord[CountWord]);
                  CountWord := CountWord + 1;
                end;
                CountWord := -1;
                while CountWord <= CountI do
                begin
                  CountWord := CountWord + 1;
                  if MassCurY[CountWord] < (ARect.Top + 2) then
                    Continue;
                  { выводим слово }
                  TextOut(MassCurX[CountWord], MassCurY[CountWord],
                    MassWord[CountWord]);
                end;
              end;
              VisualCanvas;
            end;
          atWrapBottom:
            begin
              { для каждого слова ячейки }
              EndOfSentence := FALSE;
              CountI := 0;
              while CountI <= SpacePos do
              begin
                MassWord[CountI] := '';
                CountI := CountI + 1;
              end;
              CountI := 0;
              CountWord := CurY;
              while (not EndOfSentence) do
              begin
                { для получения следующего слова ищем пробел }
                SpacePos := Pos(' ', Sentence);
                if SpacePos > 0 then
                begin
                  { получаем текущее слово плюс пробел }
                  CurWord := Copy(Sentence, 0, SpacePos);
                  { получаем остальную часть предложения }
                  Sentence := Copy(Sentence, SpacePos + 1, Length(Sentence) -
                    SpacePos);
                end
                else
                begin
                  { это - последнее слово в предложении }
                  EndOfSentence := TRUE;
                  CurWord := Sentence;
                end;
                with Canvas do
                begin
                  { если текст выходит за границы ячейки }
                  LengthText := TextWidth(CurWord) + CurX + 2;
                  if LengthText > ARect.Right then
                  begin
                    { переносим на следующую строку }
                    CurY := CurY + TextHeight(CurWord);
                    CurX := CurXDef + 2;
                  end;
                  if CountWord <> CurY then
                    CountI := CountI + 1;
                  MassWord[CountI] := MassWord[CountI] + CurWord;
                  { увеличиваем X-координату курсора }
                  CurX := CurX + TextWidth(CurWord);
                  CountWord := CurY;
                end;
              end;
              with Canvas do
              begin
                CountWord := 0;
                CurX := CurXDef + 2;
                while CountWord <= CountI do
                begin
                  case Center of
                    True:
                      begin
                        CurWord := MassWord[CountWord];
                        if Copy(CurWord, Length(CurWord) - 1, 1) = ' ' then
                          MassWord[CountWord] := Copy(CurWord, 0, Length(CurWord) -
                            1);
                        MassCurX[CountWord] := ARect.Left + ((ARect.Right -
                          ARect.Left - TextWidth(MassWord[CountWord])) div 2);
                        MassWord[CountWord] := CurWord;
                      end;
                    False: MassCurX[CountWord] := CurX;
                  end;
                  MassCurY[CountWord] := TextHeight(MassWord[CountWord]);
                  CountWord := CountWord + 1;
                end;
                CountWord := 0;
                MassCurYDef := 0;
                while CountWord <= CountI do
                begin
                  MassCurYDef := MassCurYDef + MassCurY[CountWord];
                  CountWord := CountWord + 1;
                end;
                MassCurYDef := ARect.Bottom - MassCurYDef - 2;
                CountWord := 0;
                MeanCurY := -MassCurY[CountWord];
                while CountWord <= CountI do
                begin
                  MeanCurY := MeanCurY + MassCurY[CountWord];
                  MassCurY[CountWord] := MassCurYDef + MeanCurY;
                  CountWord := CountWord + 1;
                end;
                CountWord := -1;
                while CountWord <= CountI do
                begin
                  CountWord := CountWord + 1;
                  if MassCurY[CountWord] < (ARect.Top + 2) then
                    Continue;
                  { выводим слово }
                  TextOut(MassCurX[CountWord], MassCurY[CountWord],
                    MassWord[CountWord]);
                end;
              end;
              VisualCanvas;
            end;
        end;
      end;
     
    begin
     
      VisualBox;
      VisualCanvas;
      { Начинаем рисование с верхнего левого угла ячейки }
     
      CurXDef := ARect.Left;
      CurYDef := ARect.Top;
      CurX := CurXDef + 2;
      CurY := CurYDef + 2;
      { Здесь мы получаем содержание ячейки }
     
      Sentence := Cells[ACol, ARow];
      { Если ячейка пуста выходим из процедуры }
     
      if Sentence = '' then
        Exit;
      { Проверяем длину строки (не более 256 символов) }
     
      if Length(Sentence) > 256 then
      begin
        MessageBox(0, 'Число символов не должно быть более 256.',
          'Ошибка в таблице', mb_OK);
        Cells[ACol, ARow] := '';
        Exit;
      end;
      { Узнаем сколько в предложении слов и задаем размерность массивов }
     
      SpacePos := Pos(' ', Sentence);
      { Узнаем тип выравнивания текста }
     
      if gdFixed in AState then
        Alig := AlignCaption
      else
        Alig := AlignText;
      VisualText(Alig);
    end;
     
    procedure TNewStringGrid.SetAlignCaption(Value: TAlignText);
    begin
      if Value <> FAlignCaption then
        FAlignCaption := Value;
    end;
     
    procedure TNewStringGrid.SetAlignText(Value: TAlignText);
    begin
      if Value <> FAlignText then
        FAlignText := Value;
    end;
     
    procedure TNewStringGrid.SetCenter(Value: Boolean);
    begin
      if Value <> FCenter then
        FCenter := Value;
    end;
     
    end.

