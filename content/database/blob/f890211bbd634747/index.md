---
Title: Сохранение и чтение файлов в BLOB-полях
Date: 01.01.2007
---


Сохранение и чтение файлов в BLOB-полях
=======================================

::: {.date}
01.01.2007
:::

    // Сохраняем
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      blob: TBlobStream; 
    begin 
      blob := yourDataset.CreateBlobStream(yourDataset.FieldByName('YOUR_BLOB'), bmWrite); 
      try 
        blob.Seek(0, soFromBeginning); 
        fs := TFileStream.Create('c:\your_name.doc', fmOpenRead or 
          fmShareDenyWrite); 
        try 
          blob.CopyFrom(fs, fs.Size) 
        finally 
          fs.Free 
        end; 
      finally 
        blob.Free 
      end; 
    end;
     
    // Загружаем
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      blob: TBlobStream; 
    begin 
      blob := yourDataset.CreateBlobStream(yourDataset.FieldByName('YOUR_BLOB'), bmRead); 
      try 
        blob.Seek(0, soFromBeginning); 
     
        with TFileStream.Create('c:\your_name.doc', fmCreate) do 
          try 
            CopyFrom(blob, blob.Size) 
          finally 
            Free 
          end; 
      finally 
        blob.Free 
      end; 
    end;

Взято с <https://delphiworld.narod.ru>
