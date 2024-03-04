---
Title: Как показать содержимое TMemo-поля в TDBGrid?
Date: 01.01.2007
---


Как показать содержимое TMemo-поля в TDBGrid?
=============================================

Вариант 1.

Поумолчанию, DBGrid не может отображать memo-поля. Однако, проблему
можно решить при помощи события OnDrawDataCell в DBGrid.

    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const 
                     Rect: TRect; Field: TField; State: 
                     TGridDrawState); 
     
    var 
      P: array [0..50] of char; {размер массива, это количество необходимых символов}
      bs: TBlobStream;          {из memo-поля} 
      hStr: String; 
     
    begin 
      if Field is TMemoField then 
      begin 
        with (Sender as TDBGrid).Canvas do 
        begin   {Table1Notes это TMemoField} 
          bs := TBlobStream.Create(Table1Notes, bmRead); 
          FillChar(P,SizeOf(P),#0); {строка завершается нулём} 
          bs.Read(P, 50); {читаем 50 символов из memo в blobStream} 
          bs.Free; 
          hStr := StrPas(P); 
          while Pos(#13, hStr) > 0 do  {удаляем переносы каретки и}
            hStr[Pos(#13, hStr)] := ' '; 
          while Pos(#10, hStr) > 0 do  {отступы строк}
            S[Pos(#10, hStr)] := ' '; 
     
          FillRect(Rect);  {очищаем ячейку}
          TextOut(Rect.Left, Rect.Top, hStr);  {заполняем ячейку данными из memo}
        end; 
      end; 
    end; 

**Замечание:**
перед тем, запустить пример, создайте объект TMemoField для
memo-поля двойным кликом по компоненту TTable и добавлением memo-поля.

Source: <https://forum.sources.ru>

------------------------------------------------------------------------

Вариант 2.

В обработчик события GetText TMemoField поместите следующую строку:

    Text := GrabMemoAsString(TMemoField(Sender));

и поместите следующую функцию так, чтобы к ней можно было свободно
обратиться:

    function GrabMemoAsString(TheField: TMemoField): string;
    begin
      if TheField.IsNull then
        Result := ''
      else
        with TBlobStream.Create(TheField, bmRead) do
        begin
          if Size >= 255 then
          begin
            Read(Result[1], 255);
            Result[0] := #255;
          end
          else
          begin
            Read(Result[1], Size);
            Result[0] := Chr(Size);
          end;
          Free;
          while Pos(#10, Result) > 0 do
            Result[Pos(#10, Result)] := ' ';
          while Pos(#13, Result) > 0 do
            Result[Pos(#13, Result)] := ' ';
        end;
    end;
     

Source: <https://delphiworld.narod.ru>
