---
Title: Как найти размер записи?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как найти размер записи?
========================

    procedure TMainFrm.CalculateRecordSizeClick(Sender: TObject);
    var
      MaxRecs, RecSize, RecsPerBlock, FreeSpace: Longint;
      i: Integer;
    begin
      RecSize := 0;
      with StrucGrid do
      begin
        for i := 0 to pred(RowCount) do
        begin
          case Cells[1, i][1] of
            'A': RecSize := RecSize + StrToInt(Cells[2, i]);
            'D', 'T', 'I', '+': RecSize := RecSize + 4;
            'N', '$', 'Y', '@': RecSize := RecSize + 8;
            'M', 'B', 'F', 'O', 'G': RecSize := RecSize + 10 + StrToInt(Cells[2, i]);
            'S': RecSize := RecSize + 2;
            'L': RecSize := RecSize + 1;
          end;
        end;
      end;
      RecsPerBlock := (SpinEdit2.Value - 6) div RecSize;
      FreeSpace := (SpinEdit2.Value - 6) - (RecSize * RecsPerBlock);
      MaxRecs := 65536 * RecsPerBlock;
      ShowMessage('Record Size is: ' + IntToStr(RecSize) + ' bytes' + #13#10
        + 'Records per Block: ' + IntToStr(RecsPerBlock) + #13#10
        + 'Unused Space per Block: ' + IntToStr(FreeSpace) + ' bytes' + #13#10
        + 'Max No of Records in Table: ' + FormatFloat('###############,', MaxRecs));
    end;

