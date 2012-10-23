<h1>Работа через WinAPI</h1>
<div class="date">01.01.2007</div>


<p>Раздел написан Podval (примеры к сожалению на С++)</p>
<p>Любителям WinAPI посвящается...</p>
<p>Функции FileOpen, FileSeek, FileRead.</p>
<p>Возьмем форму, положим на нее кнопку, грид и Опен диалог бокс.</p>
<p>Это для Билдера, но какая нам в данном случае разница?</p>
<pre>
void __fastcall TForm1::Button1Click(TObject *Sender)
{
int iFileHandle;
int iFileLength;
int iBytesRead;
char *pszBuffer;
if (OpenDialog1-&gt;Execute())
{
try
{
iFileHandle = FileOpen(OpenDialog1-&gt;FileName, fmOpenRead);
iFileLength = FileSeek(iFileHandle,0,2);
FileSeek(iFileHandle,0,0);
pszBuffer = new char[iFileLength+1];
iBytesRead = FileRead(iFileHandle, pszBuffer, iFileLength);
FileClose(iFileHandle);
for (int i=0;i&lt;iBytesRead;i++)
{
StringGrid1-&gt;RowCount += 1;
StringGrid1-&gt;Cells[1][i+1] = pszBuffer[i];
StringGrid1-&gt;Cells[2][i+1] = IntToStr((int)pszBuffer[i]);
}
delete [] pszBuffer;
}
catch(...)
{
Application-&gt;MessageBox("Can't perform one of the following file operations: Open, Seek, Read, Close.", "File Error", IDOK);
}
}
}
 
</pre>
<p>Потренируемся еще.</p>
<p>Функции FileExists, RenameFile, FileCreate, FileWrite, FileClose.</p>
<p>Бросим на форму Save dialog box.</p>
<pre>
#include &lt;dir.h&gt;
void __fastcall TForm1::Button1Click(TObject *Sender)
{
char szFileName[MAXFILE+4];
int iFileHandle;
int iLength;
if (SaveDialog1-&gt;Execute())
{
if (FileExists(SaveDialog1-&gt;FileName))
{
fnsplit(SaveDialog1-&gt;FileName.c_str(), 0, 0, szFileName, 0);
strcat(szFileName, ".BAK");
RenameFile(SaveDialog1-&gt;FileName, szFileName);
}
iFileHandle = FileCreate(SaveDialog1-&gt;FileName);
 
// Write out the number of rows and columns in the grid.
FileWrite(iFileHandle, (char*)&amp;(StringGrid1-&gt;ColCount), sizeof
(StringGrid1-&gt;ColCount));
FileWrite(iFileHandle, (char*)&amp;(StringGrid1-&gt;RowCount), sizeof
(StringGrid1-&gt;RowCount));
for (int x=0;x&lt;StringGrid1-&gt;ColCount;x++)
{
for (int y=0;y&lt;StringGrid1-&gt;RowCount;y++)
{
// Write out the length of each string, followed by the string itself.
 
iLength = StringGrid1-&gt;Cells[x][y].Length();
FileWrite(iFileHandle, (char*)&amp;iLength, sizeof
(iLength));
FileWrite(iFileHandle, StringGrid1-&gt;Cells[x][y].c_str(), StringGrid1-&gt;Cells[x][y].Length());
}
}
FileClose(iFileHandle);
}
}
 
</pre>
<p>(с) Оба примера взяты из хелпа по Borland C++ Builder 5.</p>
<p>Дата/время файла</p>
<p>extern PACKAGE int fastcall FileGetDate(int Handle);</p>
<p>extern PACKAGE int fastcall FileSetDate(int Handle, int Age);</p>
<p>Первоисточник тот же.</p>
<p>Атрибуты файла.</p>
<p>extern PACKAGE int __fastcall FileGetAttr(const AnsiString FileName);</p>
<p>И</p>
<p>extern PACKAGE int fastcall FileSetAttr(const AnsiString FileName, int Attr);</p>
<p>Может быть, такая функция полезна будет, хотя о программном поиске файлов и так много наговорено. Но на всякий случай, как говорится.</p>
<p>В этом примере идет поиск в текущем каталоге и каталоге Windows</p>
<pre>
void __fastcall TForm1::Button1Click(TObject *Sender)
{
char buffer[256];
GetWindowsDirectory(buffer, sizeof(buffer));
AnsiString asFileName = FileSearch(Edit1-&gt;Text, GetCurrentDir() + AnsiString(";") + AnsiString(buffer));
if (asFileName.IsEmpty())
ShowMessage(AnsiString("Couldn't find ") + Edit1-&gt;Text + ".");
else
ShowMessage(AnsiString("Found ") + asFileName + ".")
}
</pre>
<p>В дополнение к Дате/Времени</p>
<p>extern PACKAGE int __fastcall FileAge(const AnsiString FileName);</p>
<p>Для конвертации возвращаемого значения в TDateTime:</p>
<p>extern PACKAGE int fastcall FileDateToDateTime(int FileDate);</p>
