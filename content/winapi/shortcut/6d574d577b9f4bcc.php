<h1>Как программно создать ярлык?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Gavrilo</div>
<pre>
uses ShlObj, ComObj, ActiveX;
 
  procedure CreateLink(const PathObj, PathLink, Desc, Param: string);
  var
    IObject: IUnknown;
    SLink: IShellLink;
    PFile: IPersistFile;
  begin
    IObject := CreateComObject(CLSID_ShellLink);
    SLink := IObject as IShellLink;
    PFile := IObject as IPersistFile;
    with SLink do begin
      SetArguments(PChar(Param));
      SetDescription(PChar(Desc));
      SetPath(PChar(PathObj));
    end;
    PFile.Save(PWChar(WideString(PathLink)), FALSE);
  end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
