<h1>Как получить доступ к определенной части GUID?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ Manchmal wird nur ein Teil einer GUID benotigt.... }
{ You maybe have to access  just a part of a GUID. }


{ Const for the function Format(...) }
const
  fsGUID: string = 'D1: $%s'#13#10'D2: $%s'#13#10'D3: $%s'#13#10     +
    'D4: $%s $%s $%s $%s $%s $%s $%s $%s';
  fsGUIDParts: string = 'D%d:%s';

// Type for the GUID part to be shown 
type

 TGUIDPART = (guidp_NoFormat, guidp_All, guidp_D1, guidp_D2, guidp_D3, guidp_D4);
 
{ This GUIDToStringEx function give you the full GUID string 
  according with then format string FStr (you can change it !!!) }
function GUIDToStringEx(Guid: TGuid; FStr: string): string; overload;
begin
   Result := Format(FStr, [
     IntToHex(GUID.D1, 8),
     IntToHex(GUID.D2, 4),
     IntToHex(GUID.D3, 4),
     IntToHex(GUID.D4[0], 2),
     IntToHex(GUID.D4[1], 2),
     IntToHex(GUID.D4[2], 2),
     IntToHex(GUID.D4[3], 2),
     IntToHex(GUID.D4[4], 2),
     IntToHex(GUID.D4[5], 2),
     IntToHex(GUID.D4[6], 2),
     IntToHex(GUID.D4[7], 2)
     ]);
end;

{ This GUIDToStringEx function give you the part of the GUID 
  to be shown, according to the part type GUIDPart }
function GUIDToStringEx(Guid: TGuid; Part: TGUIDPART): string; overload;
var
  i: Integer;
  S: string;
begin
  S := '';
  case Part of
    guidp_NoFormat: S := GUIDToString(Guid);
    guidp_All:      S := GUIDToStringEx(Guid, fsGUID);
    guidp_D1:       S := Format(fsGUIDParts, [1, ' $' + IntToHex(GUID.D1, 8)]);
    guidp_D2:       S := Format(fsGUIDParts, [2, ' $' + IntToHex(GUID.D2, 4)]);
    guidp_D3:       S := Format(fsGUIDParts, [3, ' $' + IntToHex(GUID.D3, 4)]);
    guidp_D4:
       begin
        for i := 0 to 7 do S := S + ' $' + IntToHex(GUID.D4[i], 2);
        S := Format(fsGUIDParts, [4, S]);
      end;
    else
       S := '?';
  end;
  Result := S;
end;

{ How to use the different GUIDToStringEx functions }

procedure TForm1.Button1Click(Sender: TObject);
var
  NewGUID: TGUID;
begin
  { Create a new GUID }
  NewGUID := StringToGUID(CreateClassID);

  { Standard formated GUID string }
  label1.Caption := GUIDToStringEx(NewGUID, guidp_NoFormat) +
    #13#10+

   { Full formated GUID string acc. with fsGUID}
    GUIDToStringEx(NewGUID, fsGUID) +
    #13#10+

   { Full formated GUID string with default formating}
    GUIDToStringEx(NewGUID, guidp_All) +
    #13#10+

   { Part D3 of the GUID only }
    GUIDToStringEx(NewGUID, guidp_D3);
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

