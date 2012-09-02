<h1>Как получить значение свойства в виде варианта по тексту имени свойства?</h1>
<div class="date">01.01.2007</div>


<pre>
unit MorePropInfo;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
 
type
  TFrmMorePropInfo = class(TForm)
    Button1: TButton;
    Button2: TButton;
    ListBox1: TListBox;
    procedure Button2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  FrmMorePropInfo: TFrmMorePropInfo;
 
implementation
 
{$R *.DFM}
 
uses
  TypInfo;
 
procedure GetPropertyValues(AObj: TObject; AValues: TStrings);
var
  count: integer;
  data: PTypeData;
  default: string;
  i: integer;
  info: PTypeInfo;
  propList: PPropList;
  propInfo: PPropInfo;
  propName: string;
  value: variant;
begin
  info := AObj.ClassInfo;
  data := GetTypeData(info);
  GetMem(propList, data^.PropCount * SizeOf(PPropInfo));
  try
    count := GetPropList(info, tkAny,  propList);
    for i := 0 to count - 1 do
    begin
      propName := propList^[i]^.Name;
      propInfo := GetPropInfo(info, propName);
      if propInfo &lt;&gt; nil then
      begin
        case propInfo^.PropType^.Kind of
          tkClass, tkMethod:
            value := '$' + IntToHex(GetOrdProp(AObj, propInfo), 8);
          tkFloat:
            value := GetFloatProp(AObj, propInfo);
          tkInteger:
            value := GetOrdProp(AObj, propInfo);
          tkString, tkLString, tkWString:
            value := GetStrProp(AObj, propInfo);
          tkEnumeration:
            value := GetEnumProp(AObj, propInfo);
          else
            value := '???';
        end;
        if propInfo.default = longint($80000000) then
          default := 'none'
        else
          default := IntToStr(propInfo.default);
        AValues.Add(Format('%s: %s [default: %s]', [propName, value, default]));
        {$80000000 apparently indicates "no default"}
      end;
    end;
  finally
    FreeMem(propList, data^.PropCount * SizeOf(PPropInfo));
  end;
end;
 
 
procedure TFrmMorePropInfo.Button2Click(Sender: TObject);
var
  count: integer;
  data: PTypeData;
  i: integer;
  info: PTypeInfo;
  propList: PPropList;
  propInfo: PPropInfo;
  propName: string;
  propVal: variant;
  tmpS: string;
begin
  info := Button2.ClassInfo;
  data := GetTypeData(info);
  GetMem(propList, data^.PropCount * SizeOf(PPropInfo));
  try
    count := GetPropList(info, tkAny,  propList);
    ListBox1.Clear;
    for i := 0 to count - 1 do
    begin
      propName := propList^[i]^.Name;
      propInfo := GetPropInfo(info, propName);
      if propInfo &lt;&gt; nil then
      begin
        case propInfo^.PropType^.Kind of
          tkClass, tkMethod:
            propVal := '$' + IntToHex(GetOrdProp(Button2, propInfo), 8);
          tkFloat:
            propVal := GetFloatProp(Button2, propInfo);
          tkInteger:
            propVal := GetOrdProp(Button2, propInfo);
          tkString, tkLString, tkWString:
            propVal := GetStrProp(Button2, propInfo);
          tkEnumeration:
            propVal := GetEnumProp(Button2, propInfo);
          else
            propVal := '...';
        end;
        tmpS := propVal;
        ListBox1.Items.Add(Format('%s: %s [default: %s]', [propName, tmpS, '$'
                                             + IntToHex(propInfo.default, 8)]));
        {$80000000 apparently indicates "no default"}
      end;
    end;
  finally
    FreeMem(propList, data^.PropCount * SizeOf(PPropInfo));
  end;
end;
 
end.
</pre>

<p>Tip by Ralph Friedman</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
