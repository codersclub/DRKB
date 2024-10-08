---
Title: Как извлечь иконку из файла ярлыка?
Date: 01.01.2007
---

Как извлечь иконку из файла ярлыка?
===================================

> How to get icon from a shortcut file ?

Вариант 1:

I have found that if you use a ListView component,
to show a list of files in any folder that contains shortcuts,
then the shortcut icons do not appear correctly -
they do not show the true icon of the application to which they relate.

However, there is a a very useful feature of SHGetFileInfo,
which is SHGFI\_LINKOVERLAY. This adds the shortcut "arrow",
which is shown in the bottom left corner of any shortcut icon.

The demo code below shows the basic use of the SHGFI\_LINKOVERLAY
feature.

I have added code to this demo, to distingiush between shortcut and
non-shortcut files -
without this code, it will overlay the shortcut "arrow" irrespective
of the file type.

To show the icon of a shortcut, the following code can be used as a
demo:

1. Add the following components to a new project, and adjust their
properties according to the code below:

    ```
    // Code for DFM file:
     
    object Form1: TForm1
      Left = 379
      Top = 355
      Width = 479
      Height = 382
      Caption = 'Get Icon from Shortcut File'
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      OldCreateOrder = False
      PixelsPerInch = 96
      TextHeight = 13
      object ListView: TListView
        Left = 0
        Top = 73
        Width = 471
        Height = 275
        Align = alClient
        Columns = <
          item
            Width = 100
          end
          item
            Width = 100
          end>
        SmallImages = imgList
        TabOrder = 0
        ViewStyle = vsReport
      end
      object Panel: TPanel
        Left = 0
        Top = 0
        Width = 471
        Height = 73
        Align = alTop
        TabOrder = 1
        object btnGetFile: TButton
          Left = 16
          Top = 8
          Width = 75
          Height = 25
          Caption = 'Get file'
          TabOrder = 0
          OnClick = btnGetFileClick
        end
        object btnGetIcon: TButton
          Left = 104
          Top = 8
          Width = 75
          Height = 25
          Caption = 'Get icon'
          TabOrder = 1
          OnClick = btnGetIconClick
        end
        object edFileName: TEdit
          Left = 16
          Top = 40
          Width = 441
          Height = 21
          TabOrder = 2
        end
      end
      object dlgOpen: TOpenDialog
        Filter = 'Shortcut files|*.lnk|All files|*.*'
        Options = [ofHideReadOnly, ofNoDereferenceLinks,
          ofEnableSizing]  // - this is important !
        Left = 248
        Top = 8
      end
      object imgList: TImageList
        BlendColor = clWhite
        BkColor = clWhite
        Masked = False
        ShareImages = True
        Left = 216
        Top = 8
      end
    end
    ```

2. Add the code to the PAS file below:
     
    ```
    unit cdShortCutIcon;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Graphics, Controls, Forms,
      Dialogs, Buttons, ExtCtrls, StdCtrls, StrUtils, ShellAPI,
      CommCtrl, ImgList, ComCtrls, Classes;
     
    type
      TForm1 = class(TForm)
        dlgOpen: TOpenDialog;
        ListView: TListView;
        imgList: TImageList;
        Panel: TPanel;
        btnGetFile: TButton;
        btnGetIcon: TButton;
        edFileName: TEdit;
        procedure btnGetFileClick(Sender: TObject);
        procedure btnGetIconClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.btnGetFileClick(Sender: TObject);
    begin
      { choose file to get icon from }
      if dlgOpen.Execute then edFileName.Text := dlgOpen.FileName;
    end;
     
    procedure TForm1.btnGetIconClick(Sender: TObject);
    var
      Icon : TIcon;
      ListItem : TListItem;
      shInfo : TSHFileInfo;
      sFileType : string;
    begin
      { initialise ListView and Icon }
      ListView.SmallImages := imgList;
      Icon := TIcon.Create;
     
      try
        ListView.Items.BeginUpdate;
        ListItem := listview.items.add;{ Initialise ListView.Item.Add }
     
        { get details about file type from SHGetFileInfo }
        SHGetFileInfo(PChar(edFileName.Text), 0, shInfo,
          SizeOf(shInfo), SHGFI_TYPENAME);
        sFileType := shInfo.szTypeName;
     
        { is this a shortcut file ? }
        if shInfo.szTypeName = 'Shortcut' then
          SHGetFileInfo(PChar(edFileName.Text), 0, shInfo, SizeOf(shInfo),
            SHGFI_LINKOVERLAY or SHGFI_ICON or
            SHGFI_SMALLICON or SHGFI_SYSICONINDEX)
        else
          { ...otherwise treat it as a normal file}
          SHGetFileInfo(PChar(edFileName.Text), 0, shInfo, SizeOf(shInfo),
            SHGFI_ICON or SHGFI_SMALLICON or
            SHGFI_SYSICONINDEX);
     
        { assign icon }
        Icon.Handle := shInfo.hIcon;
     
        { List File name, Icon and FileType in ListView}
        ListItem.Caption := ExtractFileName(edFileName.Text);    //...add filename
        ListItem.SubItems.Add(sFileType); //...and filetype..
        ListItem.ImageIndex := imgList.AddIcon(Icon); //...and icon.
      finally
        ListView.Items.EndUpdate; //..free memory on icon and clean up.
        sFileType := '';
        Icon.Free;
      end;
    end;
    
    end.
    ```

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    {  Comment: 
      The procedure GetAssociatedIcon, trys via Registry to get the 
      icon (should work for small and big icons) that is associated with 
      the files shown in the explorer. 
     
      This is not my work. But I want to distribute it to you, because 
      it was really hard to find a corresonding document. 
      Thanks SuperTrax. 
    }
     
    unit AIconos;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, StdCtrls, FileCtrl;
    
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Image1: TImage;
        Image2: TImage;
        OpenDialog1: TOpenDialog;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
    
    type
      PHICON = ^HICON;
    
    var
      Form1: TForm1;
      PLargeIcon, PSmallIcon: phicon;
    
    implementation
    
    uses shellapi, registry;
    
    {$R *.DFM}
    
    procedure GetAssociatedIcon(FileName: TFilename; PLargeIcon, PSmallIcon: PHICON);
    var
      IconIndex: SmallInt;  // Position of the icon in the file 
     Icono: PHICON;       // The LargeIcon parameter of ExtractIconEx 
     FileExt, FileType: string;
      Reg: TRegistry;
      p: Integer;
      p1, p2: PChar;
      buffer: array [0..255] of Char;
    
    Label
      noassoc, NoSHELL; // ugly! but I use it, to not modify to much the original code :( 
    begin
      IconIndex := 0;
      Icono := nil;
      // ;Get the extension of the file 
      FileExt := UpperCase(ExtractFileExt(FileName));
      if ((FileExt  '.EXE') and (FileExt  '.ICO')) or not FileExists(FileName) then
      begin
        // If the file is an EXE or ICO and exists, then we can 
        // extract the icon from that file. Otherwise here we try 
        // to find the icon in the Windows Registry. 
        Reg := nil;
        try
          Reg := TRegistry.Create;
          Reg.RootKey := HKEY_CLASSES_ROOT;
          if FileExt = '.EXE' then FileExt := '.COM';
          if Reg.OpenKeyReadOnly(FileExt) then
            try
              FileType := Reg.ReadString('');
            finally
              Reg.CloseKey;
            end;
          if (FileType <> '') and Reg.OpenKeyReadOnly(FileType + '\DefaultIcon') then
            try
              FileName := Reg.ReadString('');
            finally
              Reg.CloseKey;
            end;
        finally
          Reg.Free;
        end;
    
        // If there is not association then lets try to 
        // get the default icon 
        if FileName = '' then goto noassoc;
     
        // Get file name and icon index from the association 
        // ('"File\Name",IconIndex') 
        p1 := PChar(FileName);
        p2 := StrRScan(p1, ',');
        if p2  nil then
        begin
          p         := p2 - p1 + 1; // Position de la coma 
          IconIndex := StrToInt(Copy(FileName, p + 1, Length(FileName) - p));
          SetLength(FileName, p - 1);
        end;
      end; //if ((FileExt  '.EX ... 
     
      // Try to extract the small icon 
      if ExtractIconEx(PChar(FileName), IconIndex, Icono^, PSmallIcon^, 1) <> 1 then
      begin
        noassoc:
        // That code is executed only if the ExtractIconEx return a value but 1 
        // There is not associated icon 
        // try to get the default icon from SHELL32.DLL 
     
        FileName := 'C:\Windows\System\SHELL32.DLL';
        if not FileExists(FileName) then
        begin  //If SHELL32.DLL is not in Windows\System then 
          GetWindowsDirectory(buffer, SizeOf(buffer));
          //Search in the current directory and in the windows directory 
          FileName := FileSearch('SHELL32.DLL', GetCurrentDir + ';' + buffer);
          if FileName = '' then
            goto NoSHELL; //the file SHELL32.DLL is not in the system 
        end;
     
        // Determine the default icon for the file extension 
        if (FileExt = '.DOC') then IconIndex := 1
        else if (FileExt = '.EXE') or (FileExt = '.COM') then IconIndex := 2
        else if (FileExt = '.HLP') then IconIndex := 23
        else if (FileExt = '.INI') or (FileExt = '.INF') then IconIndex := 63
        else if (FileExt = '.TXT') then IconIndex := 64
        else if (FileExt = '.BAT') then IconIndex := 65
        else if (FileExt = '.DLL') or (FileExt = '.SYS') or (FileExt = '.VBX') or
          (FileExt = '.OCX') or (FileExt = '.VXD') then IconIndex := 66
        else if (FileExt = '.FON') then IconIndex := 67
        else if (FileExt = '.TTF') then IconIndex := 68
        else if (FileExt = '.FOT') then IconIndex := 69
        else
          IconIndex := 0;
        // Try to extract the small icon 
        if ExtractIconEx(PChar(FileName), IconIndex, Icono^, PSmallIcon^, 1) <> 1 then
        begin
          //That code is executed only if the ExtractIconEx return a value but 1 
          // Fallo encontrar el icono. Solo "regresar" ceros. 
          NoSHELL:
           if PLargeIcon  nil then PLargeIcon^ := 0;
           if PSmallIcon  nil then PSmallIcon^ := 0;
         end;
       end; //if ExtractIconEx 
     
      if PSmallIcon^ 0 then
      begin //If there is an small icon then extract the large icon. 
        PLargeIcon^ := ExtractIcon(Application.Handle, PChar(FileName), IconIndex);
        if PLargeIcon^ = Null then
          PLargeIcon^ := 0;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       SmallIcon, LargeIcon: HIcon;
       Icon: TIcon;
     begin
       if not (OpenDialog1.Execute) then
         Exit;
       Icon := TIcon.Create;
       try
         GetAssociatedIcon(OpenDialog1.FileName, @LargeIcon, @SmallIcon);
         if LargeIcon <> 0 then
         begin
           Icon.Handle := LargeIcon;
           Image2.Picture.icon := Icon;
         end;
         if SmallIcon <> 0 then
         begin
           Icon.Handle := SmallIcon;
           Image1.Picture.icon := Icon;
         end;
       finally
         Icon.Destroy;
       end;
     end;
     
     end.


