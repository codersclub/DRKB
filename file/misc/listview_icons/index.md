---
Title: Пример загрузки файлов в ListView с иконками
Author: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
Date: 01.01.2007
---


Пример загрузки файлов в ListView с иконками
============================================

Вариант 1:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, comctrls, StdCtrls;
    type
      TForm1 = class(TForm)
        ListView1: TListView;
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        private
        procedure SaveListViewToFile(AListView: TListView; sFileName: string);
        procedure LoadListViewToFile(AListView: TListView; sFileName: string);
        public
      end;
    const
      Msg1 = 'File "%s" does not exist!';
      Msg2 = '"%s" is not a ListView file!';
    var
      Form1: TForm1;
    implementation
    {$R *.DFM}
    procedure TForm1.SaveListViewToFile(AListView: TListView; sFileName: string);
    var
      idxItem, idxSub, IdxImage: Integer;
      F: TFileStream;
      pText: PChar;
      sText: string;
      W, ItemCount, SubCount: Word;
      MySignature: array [0..2] of Char;
    begin
      //Initialization
      with AListView do
      begin
        ItemCount := 0;
        SubCount := 0;
        //****
        MySignature := 'LVF';
        // ListViewFile
        F := TFileStream.Create(sFileName, fmCreate or fmOpenWrite);
        F.Write(MySignature, SizeOf(MySignature));
        if Items.Count = 0 then
          // List is empty
          ItemCount := 0
        else
          ItemCount := Items.Count;
        F.Write(ItemCount, SizeOf(ItemCount));
        if Items.Count > 0 then
        begin
          for idxItem := 1 to ItemCount do
          begin
            with Items[idxItem - 1] do
            begin
              //Save subitems count
              if SubItems.Count = 0 then SubCount := 0
              else SubCount := Subitems.Count;
              F.Write(SubCount, SizeOf(SubCount));
              //Save ImageIndex
              IdxImage := ImageIndex;
              F.Write(IdxImage, SizeOf(IdxImage));
              //Save Caption
              sText := Caption;
              w := Length(sText);
              pText := StrAlloc(Length(sText) + 1);
              StrPLCopy(pText, sText, Length(sText));
              F.Write(w, SizeOf(w));
              F.Write(pText^, w);
              StrDispose(pText);
              if SubCount > 0 then
              begin
                for idxSub := 0 to SubItems.Count - 1 do
                begin
                  //Save Item's subitems
                  sText := SubItems[idxSub];
                  w := Length(sText);
                  pText := StrAlloc(Length(sText) + 1);
                  StrPLCopy(pText, sText, Length(sText));
                  F.Write(w, SizeOf(w));
                  F.Write(pText^, w);
                  StrDispose(pText);
                end;
              end;
            end;
          end;
        end;
        F.Free;
      end;
    end;
    
    procedure TForm1.LoadListViewToFile(AListView: TListView; sFileName: string);
    var
      F: TFileStream;
      IdxItem, IdxSubItem, IdxImage: Integer;
      W, ItemCount, SubCount: Word;
      pText: PChar;
      PTemp: PChar;
      MySignature: array [0..2] of Char;
      sExeName: string;
    begin
      with AListView do
      begin
        ItemCount := 0;
        SubCount := 0;
        sExeName := ExtractFileName(sFileName);
        if not FileExists(sFileName) then
        begin
          MessageBox(Handle, PChar(Format(Msg1, [sExeName])), 'I/O Error', MB_ICONERROR);
          Exit;
        end;
        F := TFileStream.Create(sFileName, fmOpenRead);
        F.Read(MySignature, SizeOf(MySignature));
        if MySignature <> 'LVF' then
        begin
          MessageBox(Handle, PChar(Format(Msg2, [sExeName])), 'I/O Error', MB_ICONERROR);
          Exit;
        end;
        F.Read(ItemCount, SizeOf(ItemCount));
        Items.Clear;
        for idxItem := 1 to ItemCount do
        begin
          with Items.Add do
          begin
            //Read imageindex
            F.Read(SubCount, SizeOf(SubCount));
            //Read imageindex
            F.Read(IdxImage, SizeOf(IdxImage));
            ImageIndex := IdxImage;
            //Read the Caption
            F.Read(w, SizeOf(w));
            pText := StrAlloc(w + 1);
            pTemp := StrAlloc(w + 1);
            F.Read(pTemp^, W);
            StrLCopy(pText, pTemp, W);
            Caption := StrPas(pText);
            StrDispose(pTemp);
            StrDispose(pText);
            if SubCount > 0 then
            begin
              for idxSubItem := 1 to SubCount do
              begin
                F.Read(w, SizeOf(w));
                pText := StrAlloc(w + 1);
                pTemp := StrAlloc(w + 1);
                F.Read(pTemp^, W);
                StrLCopy(pText, pTemp, W);
                Items[idxItem - 1].SubItems.Add(StrPas(pText));
                StrDispose(pTemp);
                StrDispose(pText);
              end;
            end;
          end;
        end;
        F.Free;
      end;
    end;
    
    // Example:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // Save Items and Clear the ListView
      SaveListViewToFile(ListView1, 'MyListView.sav');
      ListView1.Items.Clear;
    end;

    procedure TForm1.Button2Click(Sender: TObject);
    begin
      // Load Items
      LoadListViewToFile(ListView1, 'MyListView.sav');
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Даниил Карапетян (delphi4all@narod.ru)

Удобнее всего воспользоваться компонентом ListView. Его используют
многие программы, так как он позволяет очень просто создать удобный
список.

Вначале создадим ImageList и с помощью функции WinAPI SHGetFileInfo
заполним его иконками, связанными со всеми зарегистрированными
расширениями. Затем, при выборе пользователем в DirectoryListBox
каталога, найдем все файлы в этом каталоге и для каждого определим
иконку при помощи той же функции SHGetFileInfo. И еще к каждому элементу
списка добавляется размер файла. Если вывести список в виде таблицы (для
этого нужно выбрать пункт Table в ComboBox), то справа от имени каждого
файла окажется его размер.

    uses ShellAPI;
     
    procedure UpdateFiles;
    var
      sr: TSearchRec;
      li: TListItem;
      fi: TSHFileInfo;
      ext: string;
      IconIndex: word;
      ic: TIcon;
    begin
      Form1.ListView1.Items.BeginUpdate;
      Form1.ListView1.Items.Clear;
      if FindFirst(Form1.DirectoryListBox1.Directory + '*.*', faAnyFile, sr)= 0 then
     repeat
        if sr.Attr and faDirectory <> 0 then continue;
        li := Form1.ListView1.Items.Add;
     
        li.Caption := sr.Name;
        ext := LowerCase(ExtractFileExt(li.Caption));
        ShGetFileInfo(PChar('*' + ext), 0, fi, SizeOf(fi),
          SHGFI_SMALLICON or SHGFI_SYSICONINDEX or SHGFI_TYPENAME);
        li.ImageIndex := fi.iIcon;
        if sr.Size < 1024
          then li.SubItems.Add(IntToStr(sr.Size) + ' byte')
          else if sr.Size < 1024 * 1024
            then li.SubItems.Add(IntToStr(round(sr.Size / 1024)) + ' KByte')
            else li.SubItems.Add(IntToStr(round(sr.Size / (1024 * 1024))) + ' MByte');
     
        li.SubItems.Add(fi.szTypeName);
      until FindNext(sr) <> 0;
      FindClose(sr);
      Form1.ListView1.Items.EndUpdate;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      fi: TSHFileInfo;
      lc: TListColumn;
    begin
      DriveComboBox1.DirList := DirectoryListBox1;
      with ListView1 do begin
        SmallImages := TImageList.CreateSize(16,16);
        SmallImages.Handle := ShGetFileInfo('*.*', 0, fi,
          SizeOf(fi), SHGFI_SMALLICON or SHGFI_ICON
     
          or SHGFI_SYSICONINDEX);
        LargeImages := TImageList.Create(nil);
        LargeImages.Handle := ShGetFileInfo('*.*', 0, fi,
          SizeOf(fi), SHGFI_LARGEICON or SHGFI_ICON
          or SHGFI_SYSICONINDEX);
        lc := Columns.Add;
        lc.Caption := 'Name';
        lc := Columns.Add;
        lc.Caption := 'Size';
        ComboBox1.Items.Add('Icons');
        ComboBox1.Items.Add('List');
        ComboBox1.Items.Add('Table');
        ComboBox1.Items.Add('SmallIcons');
        ComboBox1.ItemIndex := 0;
     
      end;
      UpdateFiles;
    end;
     
    procedure TForm1.DirectoryListBox1Change(Sender: TObject);
    begin
      UpdateFiles;
    end;
     
    procedure TForm1.ComboBox1Click(Sender: TObject);
    begin
      case ComboBox1.ItemIndex of
        0: ListView1.ViewStyle := vsIcon;
        1: ListView1.ViewStyle := vsList;
        2: ListView1.ViewStyle := vsReport;
        else ListView1.ViewStyle := vsSmallIcon;
      end;
    end;

