Показать файлы с ассоциированными с ними иконками в TListView
=============================================================

::: {.date}
01.01.2007
:::

    { 
      The following example shows how to show all files and their 
      associated icons of a folder in a TListView. 
      To test the code, you need a ListView1 and a ImageList1 where the icons are stored. 
    }
     
     
     uses
       ShellApi;
     
     procedure LV_InsertFiles(strPath: string; ListView: TListView; ImageList: TImageList);
     var
       i: Integer;
       Icon: TIcon;
       SearchRec: TSearchRec;
       ListItem: TListItem;
       FileInfo: SHFILEINFO;
     begin
       // Create a temporary TIcon 
      Icon := TIcon.Create;
       ListView.Items.BeginUpdate;
       try
         // search for the first file 
        i := FindFirst(strPath + '*.*', faAnyFile, SearchRec);
         while i = 0 do
         begin
           with ListView do
           begin
             // On directories and volumes 
            if ((SearchRec.Attr and FaDirectory <> FaDirectory) and
               (SearchRec.Attr and FaVolumeId <> FaVolumeID)) then
             begin
               ListItem := ListView.Items.Add;
               //Get The DisplayName 
              SHGetFileInfo(PChar(strPath + SearchRec.Name), 0, FileInfo,
                 SizeOf(FileInfo), SHGFI_DISPLAYNAME);
               Listitem.Caption := FileInfo.szDisplayName;
               // Get The TypeName 
              SHGetFileInfo(PChar(strPath + SearchRec.Name), 0, FileInfo,
                 SizeOf(FileInfo), SHGFI_TYPENAME);
               ListItem.SubItems.Add(FileInfo.szTypeName);
               //Get The Icon That Represents The File 
              SHGetFileInfo(PChar(strPath + SearchRec.Name), 0, FileInfo,
                 SizeOf(FileInfo), SHGFI_ICON or SHGFI_SMALLICON);
               icon.Handle := FileInfo.hIcon;
               ListItem.ImageIndex := ImageList.AddIcon(Icon);
               // Destroy the Icon 
              DestroyIcon(FileInfo.hIcon);
             end;
           end;
           i := FindNext(SearchRec);
         end;
       finally
         Icon.Free;
         ListView.Items.EndUpdate;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       // Assign a Imagelist to the ListView 
      ListView1.SmallImages := ImageList1;
       // Show Listview in Report Style and add 2 Columns 
      ListView1.ViewStyle := vsReport;
       ListView1.Columns.Add;
       ListView1.Columns.Add;
       LV_InsertFiles('C:\Windows\', ListView1, ImageList1);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 

    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, comctrls, StdCtrls;
     
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
      MySignature: array[0..2] of Char;
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
              if SubItems.Count = 0 then
                SubCount := 0
              else
                SubCount := Subitems.Count;
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
      MySignature: array[0..2] of Char;
      sExeName: string;
    begin
      with AListView do
      begin
        ItemCount := 0;
        SubCount := 0;
        sExeName := ExtractFileName(sFileName);
        if not FileExists(sFileName) then
        begin
          MessageBox(Handle, PChar(Format(Msg1, [sExeName])), 'I/O Error',
            MB_ICONERROR);
          Exit;
        end;
        F := TFileStream.Create(sFileName, fmOpenRead);
        F.Read(MySignature, SizeOf(MySignature));
        if MySignature <> 'LVF' then
        begin
          MessageBox(Handle, PChar(Format(Msg2, [sExeName])), 'I/O Error',
            MB_ICONERROR);
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

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>
