---
Title: Получаем имена файлов, скопированных в буфер обмена
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получаем имена файлов, скопированных в буфер обмена
===================================================

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      f: THandle; 
      buffer: array [0..MAX_PATH] of Char; 
      i, numFiles: Integer; 
    begin 
      if not Clipboard.HasFormat(CF_HDROP) then Exit; 
      Clipboard.Open; 
      try 
        f := Clipboard.GetAsHandle(CF_HDROP); 
        if f <> 0 then 
        begin 
          numFiles := DragQueryFile(f, $FFFFFFFF, nil, 0); 
          memo1.Clear; 
          for i := 0 to numfiles - 1 do 
          begin 
            buffer[0] := #0; 
            DragQueryFile(f, i, buffer, SizeOf(buffer)); 
            memo1.Lines.Add(buffer); 
          end; 
        end; 
      finally 
        Clipboard.Close; 
      end; 
    end;


