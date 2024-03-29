---
Title: Кодирование по спирали
Author: ___Nikolay
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Кодирование по спирали
======================


    unit uMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Grids, StdCtrls, Buttons, ExtCtrls;
     
    type
      TfmMain = class(TForm)
        sgMatrix: TStringGrid;
        edEncode: TEdit;
        edDecode: TEdit;
        btEncode: TSpeedButton;
        btDecode: TSpeedButton;
        Label1: TLabel;
        chAnimation: TCheckBox;
        procedure btEncodeClick(Sender: TObject);
        procedure btDecodeClick(Sender: TObject);
      private
        { Private declarations }
        procedure ClearMatrix; // Очистит матрицу
        procedure WriteToMatrix(s: string; bSpiralWriteMode: boolean); // Записываем в матрицу
        function ReadFromMatrix(bSpiralWriteMode: boolean): string; // Считываем из матрицы
      public
        { Public declarations }
      end;
     
    var
      fmMain: TfmMain;
     
    implementation
     
    {$R *.DFM}
     
    // Записываем в матрицу
    procedure TfmMain.WriteToMatrix(s: string; bSpiralWriteMode: boolean);
    var
      c, r, i, iWriteSymbols, iStep, iDirection, iIncStep, iHalfCell, x, y: integer;
      pCursor: TPoint;
    begin
      sgMatrix.Selection := TGridRect(Rect(-1, -1, -1, -1));
      GetCursorPos(pCursor);
      iHalfCell := sgMatrix.DefaultColWidth div 2; // Половина ширины ячейки
     
      // Символы в матрицу вносим по спирали, начиная с центра
      if bSpiralWriteMode then
      begin
        c := 5; // Индекс колонки
        r := 5; // Индекс строки
        iWriteSymbols := 0; // Кол-во вписанных символов
        iStep := 1; // Шаг - кол-во вписываемых символов в одном направлении
        iDirection := 0; // Направление: 1 - вверх, 2 - вправо, 3 - вниз, 4 - влево
        iIncStep := -1; // Дельта шага
     
        for i := 1 to Length(s) do
        begin
          sgMatrix.Cells[c, r] := s[i];
     
          // Визуализировать
          if chAnimation.Checked then
          begin
            Application.ProcessMessages;
            x := fmMain.Left + sgMatrix.Left + sgMatrix.CellRect(c, r).Left + iHalfCell;
            y := fmMain.Top + sgMatrix.Top + sgMatrix.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
            SetCursorPos(x, y);
            sgMatrix.Repaint;
            Sleep(30);
          end;
          inc(iWriteSymbols);
     
          { Если кол-во символов, которые нужно вписывать в одном
            направлении, достигло предела - тогда нужно поворачивать }
          if iWriteSymbols = iStep then
          begin
            // Определим следующее направление
            inc(iDirection);
            if iDirection = 5 then
              iDirection := 1;
     
            iWriteSymbols := 0;
     
            Inc(iIncStep);
            if iIncStep = 2 then
            begin
              inc(iStep);
              iIncStep := 0;
            end;
          end;
     
          // Определим следующую клетку для записи
          case iDirection of
            1: dec(r);
            2: inc(c);
            3: inc(r);
            4: dec(c);
          end;
        end; // Вносим по спирали
      end
      else // Вносим по строкам
      begin
        i := 1;
        for r := 0 to sgMatrix.RowCount - 1 do
          for c := 0 to sgMatrix.ColCount - 1 do
          begin
            sgMatrix.Cells[c, r] := s[i];
            inc(i);
     
            // Визуализировать
            if chAnimation.Checked then
            begin
              Application.ProcessMessages;
              x := fmMain.Left + sgMatrix.Left + sgMatrix.CellRect(c, r).Left + iHalfCell;
              y := fmMain.Top + sgMatrix.Top + sgMatrix.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
              SetCursorPos(x, y);
              sgMatrix.Repaint;
              Sleep(30);
            end;
          end;
      end;
      SetCursorPos(pCursor.x, pCursor.y);
    end;
     
    procedure TfmMain.btEncodeClick(Sender: TObject);
    const
      sMsgLengthCheck = 'Длина текста должна быть равна 121';
    var
      s: string;
    begin
      s := Trim(edEncode.Text);
     
      if Length(s) <> 121 then
      begin
        MessageDlg(sMsgLengthCheck, mtInformation, [mbOk], 0);
        Exit;
      end;
     
      edDecode.Text := '';
      ClearMatrix;
      WriteToMatrix(s, true);
      edDecode.Text := ReadFromMatrix(false);
    end;
     
    procedure TfmMain.btDecodeClick(Sender: TObject);
    const
      sMsgLengthCheck = 'Длина текста должна быть равна 121';
    var
      s: string;
    begin
      s := Trim(edDecode.Text);
     
      if Length(s) <> 121 then
      begin
        MessageDlg(sMsgLengthCheck, mtInformation, [mbOk], 0);
        Exit;
      end;
     
      edEncode.Text := '';
      ClearMatrix;
      WriteToMatrix(s, false);
      edEncode.Text := ReadFromMatrix(true);
    end;
     
    // Очистит матрицу
    procedure TfmMain.ClearMatrix;
    var
      r, c: integer;
    begin
      for r := 0 to sgMatrix.RowCount - 1 do
        for c := 0 to sgMatrix.ColCount - 1 do
          sgMatrix.Cells[c, r] := '';
    end;
     
    // Считываем из матрицы
    function TfmMain.ReadFromMatrix(bSpiralWriteMode: boolean): string;
    var
      c, r, i, iWriteSymbols, iStep, iDirection, iIncStep, x, y, iHalfCell: integer;
      pCursor: TPoint;
      sResult: string;
    begin
      sgMatrix.Selection := TGridRect(Rect(-1, -1, -1, -1));
      GetCursorPos(pCursor);
      sResult := '';
      iHalfCell := sgMatrix.DefaultColWidth div 2; // Половина ширины ячейки
     
      if bSpiralWriteMode then
      begin
        c := 5; // Индекс колонки
        r := 5; // Индекс строки
        iWriteSymbols := 0; // Кол-во вписанных символов
        iStep := 1; // Шаг - кол-во вписываемых символов в одном направлении
        iDirection := 0; // Направление: 1 - вверх, 2 - вправо, 3 - вниз, 4 - влево
        iIncStep := -1; // Дельта шага
        sResult := '';
     
        // Символы из матрицы считываем по спирали, начиная с центра
        for i := 1 to 121 do
        begin
          sResult := sResult + sgMatrix.Cells[c, r];
          sgMatrix.Cells[c, r] := '';
     
          // Визуализировать
          if chAnimation.Checked then
          begin
            Application.ProcessMessages;
            x := fmMain.Left + sgMatrix.Left + sgMatrix.CellRect(c, r).Left + iHalfCell;
            y := fmMain.Top + sgMatrix.Top + sgMatrix.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
            SetCursorPos(x, y);
            sgMatrix.Repaint;
            Sleep(30);
          end;
          inc(iWriteSymbols);
     
          { Если кол-во символов, которые нужно считать в одном
            направлении, достигло предела - тогда нужно поворачивать }
          if iWriteSymbols = iStep then
          begin
            // Определим следующее направление
            inc(iDirection);
            if iDirection = 5 then
              iDirection := 1;
     
            iWriteSymbols := 0;
     
            Inc(iIncStep);
            if iIncStep = 2 then
            begin
              inc(iStep);
              iIncStep := 0;
            end;
          end;
     
          // Определим следующую клетку считывания
          case iDirection of
            1: dec(r);
            2: inc(c);
            3: inc(r);
            4: dec(c);
          end;
        end;
      end
      else // Считываем по строкам
      begin
        for r := 0 to sgMatrix.RowCount - 1 do
          for c := 0 to sgMatrix.ColCount - 1 do
          begin
            sResult := sResult + sgMatrix.Cells[c, r];
            sgMatrix.Cells[c, r] := '';
     
                    // Визуализировать
            if chAnimation.Checked then
            begin
              Application.ProcessMessages;
              x := fmMain.Left + sgMatrix.Left + sgMatrix.CellRect(c, r).Left + iHalfCell;
              y := fmMain.Top + sgMatrix.Top + sgMatrix.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
              SetCursorPos(x, y);
              sgMatrix.Repaint;
              Sleep(30);
            end;
          end;
      end;
     
      Result := sResult;
      SetCursorPos(pCursor.x, pCursor.y);
    end;
     
    end.


