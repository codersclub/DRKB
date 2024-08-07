---
Title: Компонет TWrapGrid, осуществляющий перенос текста в TStringGrid
Date: 01.01.2002
Author: Luis J. de la Rosa, delarosa@ix.netcom.com
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Компонет TWrapGrid, осуществляющий перенос текста в TStringGrid
===============================================================

Я наконец нашел время и создал заказной компонент TWrapGrid,
функционально идентичный TStringGrid, но умеющий переносить текст в
ячейках. Пока это бета-версия, поэтому поэкспериментируйте с ним, и в
случае наличия каких-либо замечаний или предложений не забудьте
уведомить об этом меня. При использовании компонента не забывайте про
RowHeights (или DefaultRowHeight), т.к. при переносе текста потребуется
отобразить несколько строк.

Для использования скопируйте код в модуль, сохраните его с именем
"Wrapgrid.PAS" и следуйте за инструкциями, расположенными в верхней
части кода.

Присылайте свой комментарии и пожелания. Вот код:

    {  Код заказного компонента для Delphi.
     
    Позволяет переносить текст в TStringGrid, отсюда и его имя - TWrapGrid.
    Автор Luis J. de la Rosa.
    E-mail: delarosa@ix.netcom.com
    Вы свободны в использовании, распространении и улучшении кода.
     
    Для использования:
    - Выберите в Delphi пункты меню 'Options' - 'Install Components'.
    - Нажмите 'Add'.
    - Найдите и выберите файл с именем 'Wrapgrid.PAS'.
    - Нажмите 'OK'.
    - После этого вы увидете компонент во вкладке "Samples" палитры компонентов
      Delphi.
    - После этого вы можете использовать компонент вместо стандартного TStringGrid.
     
    Пожалуйста шлите любые комментарии и пожелания на адрес delarosa@ix.netcom.com.
    Успехов!
     
    Несколько дополнительных замечаний по коду:
    - Методы Create и DrawCell были перекрыты. Everything else should
      behave just like a TStringGrid.
    - The Create sets the DefaultDrawing to False, so you don't need to.
     
    Also, I am using the pure block emulation style of programming, making my
    code easier to read.
    }
     
    unit Wrapgrid;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, Grids;
     
    type
     
      TWrapGrid = class(TStringGrid)
      private
        { Private declarations }
      protected
        { Protected declarations }
        { Процедура DrawCell осуществляет перенос текста в ячейке }
        procedure DrawCell(ACol, ARow: Longint; ARect: TRect;
          AState: TGridDrawState); override;
      public
        { Public declarations }
        { Процедура Create перекрывается для того, чтобы использовать процедуру DrawCell
        по умолчанию }
        constructor Create(AOwner: TComponent); override;
      published
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    constructor TWrapGrid.Create(AOwner: TComponent);
    begin
     
      { Создаем TStringGrid }
      inherited Create(AOwner);
     
      { Заставляем компонент перерисовываться нашей процедурой по умолчанию DrawCell }
      DefaultDrawing := FALSE;
    end;
     
    { Процедура DrawCell осуществляет перенос текста в ячейке }
     
    procedure TWrapGrid.DrawCell(ACol, ARow: Longint; ARect: TRect;
     
      AState: TGridDrawState);
    var
     
      Sentence, { Выводимый текст }
      CurWord: string; { Текущее выводимое слово }
      SpacePos, { Позиция первого пробела }
      CurX, { Х-координата 'курсора' }
      CurY: Integer; { Y-координата 'курсора' }
      EndOfSentence: Boolean; { Величина, указывающая на заполненность ячейки }
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
     
      { Начинаем рисование с верхнего левого угла ячейки }
      CurX := ARect.Left;
      CurY := ARect.Top;
     
      { Здесь мы получаем содержание ячейки }
      Sentence := Cells[ACol, ARow];
     
      { для каждого слова ячейки }
      EndOfSentence := FALSE;
      while (not EndOfSentence) do
      begin
        { для получения следующего слова ищем пробел }
        SpacePos := Pos(' ', Sentence);
        if SpacePos > 0 then
        begin
          { получаем текущее слово плюс пробел }
          CurWord := Copy(Sentence, 0, SpacePos);
     
          { получаем остальную часть предложения }
          Sentence := Copy(Sentence, SpacePos + 1, Length(Sentence) - SpacePos);
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
          if (TextWidth(CurWord) + CurX) > ARect.Right then
          begin
            { переносим на следующую строку }
            CurY := CurY + TextHeight(CurWord);
            CurX := ARect.Left;
          end;
     
          { выводим слово }
          TextOut(CurX, CurY, CurWord);
          { увеличиваем X-координату курсора }
          CurX := CurX + TextWidth(CurWord);
        end;
      end;
    end;
     
    procedure Register;
    begin
     
      { Вы можете изменить закладку Samples на любую другую
      палитре компонентов Delphi }
      RegisterComponents('Samples', [TWrapGrid]);
    end;
     
    end.

