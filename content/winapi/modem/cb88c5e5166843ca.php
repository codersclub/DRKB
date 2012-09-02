<h1>Как получить список установленных модемов в Win95/98?</h1>
<div class="date">01.01.2007</div>


<pre>
unit PortInfo;
 
interface
 
uses Windows, SysUtils, Classes, Registry;
 
function EnumModems: TStrings;
 
implementation
 
function EnumModems: TStrings;
var
  R: TRegistry;
  s: ShortString;
  N: TStringList;
  i: integer;
  j: integer;
begin
  Result := TStringList.Create;
  R := TRegistry.Create;
  try
    with R do
      begin
        RootKey := HKEY_LOCAL_MACHINE;
        if OpenKey('\System\CurrentControlSet\Services\Class\Modem', False) then
          if HasSubKeys then
            begin
              N := TStringList.Create;
              try
                GetKeyNames(N);
                for i := 0 to N.Count - 1 do
                  begin
                    closekey; { + }
                    openkey('\System\CurrentControlSet\Services\Class\Modem', false); { + }
                    OpenKey(N[i], False);
                    s := ReadString('AttachedTo');
                    for j := 1 to 4 do
                      if Pos(Chr(j + Ord('0')), s) &gt; 0 then
                        Break;
                    Result.AddObject(ReadString('DriverDesc'), TObject(j));
                    CloseKey;
                  end;
              finally
                N.Free;
              end;
            end;
      end;
  finally
    R.Free;
  end;
end;
 
end.
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
