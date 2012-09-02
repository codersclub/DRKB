<h1>Как создать shortcut-файл (.lnk)?</h1>
<div class="date">01.01.2007</div>


<pre>
uses ShlObj, ActiveX, ComObj;
...

 
procedure CreateShortCut(ShortCutName, Parameters, FileName: string);
var ShellObject: IUnknown;
  ShellLink: IShellLink;
  PersistFile: IPersistFile;
  FName: WideString;
begin
  ShellObject := CreateComObject(CLSID_ShellLink);
  ShellLink := ShellObject as IShellLink;
  PersistFile := ShellObject as IPersistFile;
  with ShellLink do
    begin
      SetArguments(PChar(Parameters));
      SetPath(PChar(FileName));
      SetWorkingDirectory(PChar(extractfilepath(FileName)));
      FName := ShortCutName;
      PersistFile.Save(PWChar(FName), False);
    end;
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

