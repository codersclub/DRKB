---
Title: Перемещение по таблице с помощью вертикальной полосы прокрутки
Date: 01.01.2007
---


Перемещение по таблице с помощью вертикальной полосы прокрутки
==============================================================

::: {.date}
01.01.2007
:::

Это небольшое исправление к исходному коду VCL, позволяющее поддерживать
перемещение по таблице с помощью изменения позиции движка вертикальной
полосы прокрутки.

(Примечание: это работает только с таблицами Paradox и BDE. Для
использования этого кода с другими таблицами/движками вам необходимо
заменить DBIGetSeqNo на функцию, надежно возвращающую текущую позицию
записи вне зависимости от того, использует ли таблица индекс или нет.)

В DBGRID.PAS измените две следующих процедуры:

    procedure TCustomDBGrid.UpdateScrollBar;
    var
      Pos: Integer;
      mPos, mMax: longint;
    begin
      if FDatalink.Active and HandleAllocated then
        with FDatalink.DataSet do
        begin
          UpdateCursorPos;
          if (DBIGetSeqNo(Handle, mPos) = DBIERR_NONE) then
          begin
            mMax := RecordCount;
            while mMax > 1000 do
            begin
              mMax := mMax div 10;
              mPos := mPos div 10;
            end;
            SetScrollRange(Self.Handle, SB_VERT, 1, mMax, False);
          end
          else
          begin
            if BOF then
              mPos := 0
            else if EOF then
              mPos := 4
            else
              mPos := 2;
            SetScrollRange(Self.Handle, SB_VERT, 0, 4, False);
          end; (**)
          if GetScrollPos(Self.Handle, SB_VERT) <> mPos then
            SetScrollPos(Self.Handle, SB_VERT, mPos, True);
        end;
    end;
     
    procedure TCustomDBGrid.WMVScroll(var Message: TWMVScroll);
    var
      mMin, mMax: integer;
      RecCount, RecNo, NewRecNo: longint;
    begin
      if not AcquireFocus then
        Exit;
      if FDatalink.Active then
        with Message, FDataLink.DataSet, FDatalink do
          case ScrollCode of
            SB_LINEUP: MoveBy(-ActiveRecord - 1);
            SB_LINEDOWN: MoveBy(RecordCount - ActiveRecord);
            SB_PAGEUP: MoveBy(-VisibleRowCount);
            SB_PAGEDOWN: MoveBy(VisibleRowCount);
            SB_THUMBPOSITION:
              if (DBIGetSeqNo(Handle, RecNo) = DBIERR_NONE) then
              begin
                GetScrollRange(self.Handle, SB_VERT, mMin, mMax);
                NewRecNo := Pos * (FDataLink.DataSet.RecordCount div mMax);
                MoveBy(NewRecNo - RecNo);
              end
              else
                case Pos of
                  0: First;
                  1: MoveBy(-VisibleRowCount);
                  2: Exit;
                  3: MoveBy(VisibleRowCount);
                  4: Last;
                end;
            SB_BOTTOM: Last;
            SB_TOP: First;
          end;
    end;

Имейте в виду, что из-за небольшой ошибки в VCL (MoveBy использует
integer-параметр вместо longint), могут быть проблемы с большими
таблицами (RecordCount\>MaxInt). Объяснение этому факту я нашел в
журнале Delphi Magazine. Для больших таблиц вы должны заменить вызовы
MoveBy на DBISetToSeqNo или DBIGetRelativeRecord. Не забудьте после
данного вызова вызвать Resnyc([] или Refresh!

P.S. Пока вы ковыряетесь в DBGRIDS.PAS: найдите и замените TitleColor на
FixedColor в TCustomDBGrid.Create и в TCustomDBGrid.DrawCell. Значение
свойства FixedColor влияет на показ заголовков колонок, и они будут
выводится как и ожидалось.

Взято с <https://delphiworld.narod.ru>
