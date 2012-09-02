<h1>Как прочитать значение свойства компонента по имени?</h1>
<div class="date">01.01.2007</div>



<p>You may need to know at runtime what properties are available for a particular component at runtime. The list can be obtained by a call to GetPropList. The types, functions and procedures, including GetPropList, that allow access to this property information reside in the VCL source file TYPINFO.PAS.</p>

<p>GetPropList Parameters</p>

<pre>
function GetPropList(TypeInfo: PTypeInfo; TypeKinds: TTypeKinds; PropList: PPropList): Integer;
</pre>

<p>The first parameter for GetPropList is of type PTypeInfo, and is part of the RTTI (Run Time Type Information) available for any object. The record structure defined:</p>

<pre>
PPTypeInfo = ^PTypeInfo;
PTypeInfo = ^TTypeInfo;
TTypeInfo = record
  Kind: TTypeKind;
  Name: ShortString;
  {TypeData: TTypeData}
end;
</pre>

<p>The TTypeInfo record can be accessed through the objects ClassInfo property. For example, if you were getting the property list of a TButton, the call might look, so far, like this:</p>

<pre>
GetPropList(Button1.ClassInfo, ....
</pre>

<p>The second parameter, of type TTypeKinds, is a set type that acts as a filter for the kinds of properties to include in the list. There are a number of valid entries that could be included in the set (see TYPEINFO.PAS), but tkProperties covers the majority. Now our call to GetPropList would look like:</p>

<pre>
GetPropList(Button1.ClassInfo, tkProperties ....
</pre>

<p>The last parameter, PPropList is an array of PPropInfo and is defined in TYPEINFO.PAS:</p>

<pre>
PPropList = ^TPropList;
TPropList = array[0..16379] of PPropInfo;
</pre>

<p>Now the call might read:</p>

<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  PropList: PPropList;
begin
  PropList := AllocMem(SizeOf(PropList^));
  GetPropList(TButton.ClassInfo, tkProperties + [tkMethod], PropList);
{...}
</pre>

<p>Getting Additional Information from the TTypeInfo Record:</p>

<p>The example at the end of this document lists not just the property name, but it's type. The name of the property type resides in an additional set of structures. Let's take a second look at the TPropInfo record. Notice that it contains a PPTypeInfo that points ultimately to a TTypeInfo record. TTypeInfo contains the class name of the property.</p>

<pre>
PPropInfo = ^TPropInfo;
TPropInfo = packed record
  PropType: PPTypeInfo;
  GetProc: Pointer;
  SetProc: Pointer;
  StoredProc: Pointer;
  Index: Integer;
  Default: Longint;
  NameIndex: SmallInt;
  Name: ShortString;
end;
 
 
PPTypeInfo = ^PTypeInfo;
PTypeInfo = ^TTypeInfo;
TTypeInfo = record
  Kind: TTypeKind;
  Name: ShortString;
  {TypeData: TTypeData}
end;
</pre>

<p>The example below shows how to set up the call to GetPropList, and how to access the array elements. TForm will be referenced in this example instead of TButton, but you can substitute other values in the GetPropList call. The visible result will be to fill the list with the property name and type of the TForm properties.</p>

<p>This project requires a TListBox. Enter the code below in the forms OnCreate event handler.</p>

<pre>
uses
  TypInfo;
 
 
procedure TForm1.FormCreate(Sender: TObject);
var
  PropList: PPropList;
  i: integer;
begin
  PropList := AllocMem(SizeOf(PropList^));
  i := 0;
  try
    GetPropList(TForm.ClassInfo, tkProperties + [tkMethod], PropList);
    while (PropList^[i] &lt;&gt; Nil) and (i &lt; High(PropList^)) do
    begin
      ListBox1.Items.Add(PropList^[i].Name + ': ' + PropList^[i].PropType^.Name);
      Inc(i);
    end;
  finally
    FreeMem(PropList);
  end;
end;
</pre>


<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
