---
Title: Как добавить текущую страницу TWebBrowser в favorites?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как добавить текущую страницу TWebBrowser в favorites?
======================================================

    // You need: 1 TEdit, 2 TButtons, 1 TWebbrowser 
    // Du brauchst: 1 TEdit, 2 TButtons, 1 TWebbrowser 
     
    const 
      NotAllowed: set of Char = ['"'] + ['/'] + ['\'] + ['?'] + [':'] + ['*'] + 
        ['<'] + ['>'] + ['|']; 
     
    implementation 
     
    {$R *.DFM} 
     
    function Load(Path, Key: string): string; 
    var 
      Reg: TRegistry; 
    begin 
      Reg := TRegistry.Create; 
      try 
        Reg.RootKey := HKEY_CURRENT_USER; 
        Reg.OpenKey(Path, False); 
        try 
          Result := Reg.ReadString(Key); 
        except 
          Result := ''; 
        end; 
        Reg.CloseKey; 
      finally 
        Reg.Free; 
      end; 
    end; 
     
    function WinDir: string; 
    var 
      WinDir: PChar; 
    begin 
      WinDir := StrAlloc(MAX_PATH); 
      GetWindowsDirectory(WinDir, MAX_PATH); 
      Result := string(WinDir); 
      if Result[Length(Result)] <> '\' then 
        Result := Result + '\'; 
      StrDispose(WinDir); 
    end; 
     
    function GetSysDir: string; 
    var 
      dir: array [0..MAX_PATH] of Char; 
    begin 
      GetSystemDirectory(dir, MAX_PATH); 
      Result := StrPas(dir); 
    end; 
     
    // Navigate to a page 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Webbrowser1.Navigate(edit1.Text); 
    end; 
     
    // Add the current page to the favorites 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    var 
      url: TStringList; 
      fav: string; 
      title, b: string; 
      i: Integer; 
      c: Char; 
    begin 
      fav := Load('Software\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders','Favorites'); 
      url := TStringList.Create; 
      try 
        url.Add('[InternetShortcut]'); 
        url.Add('URL=' + webbrowser1.LocationURL); 
        url.Add('WorkingDirectory=' + WinDir()); 
        url.Add('IconIndex=0'); 
        url.Add('ShowCommand=7'); 
        url.Add('IconFile=' + GetSysDir() + '\url.dll'); 
        title := Webbrowser1.LocationName; 
        b := ''; 
        for i := 1 to Length(title) do 
        begin 
          c := title[i]; 
          if not (c in NotAllowed) then 
          begin 
            b := b + Webbrowser1.LocationName[i]; 
          end; 
        end; 
        url.SaveToFile(fav + '\' + b + '.url'); 
      finally 
        url.Free; 
      end; 
    end; 
     
    end.

