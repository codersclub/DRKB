<h1>Получить текст элемента перечисляемого типа</h1>
<div class="date">01.01.2007</div>


<pre>
// For example, if you have some enum type
// Als Beispiel, wenn dieser Aufzahlungstyp vorhanden ist
 
{....} 
 
type 
  TYourEnumType = (One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten); 
 
{....} 
 
{ 
 And you want in run-time to get a string with same value for each of 
 them (for example, fill the Listbox items with enum values), then you 
 can use the next procedure: 
} 
 
uses TypInfo; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  i: Integer; 
begin 
  for i := Ord(Low(TYourEnumType)) to Ord(High(TYourEnumType)) do 
    ListBox1.Items.Add(GetEnumName(TypeInfo(TYourEnumType), i)); 
end;
 
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
