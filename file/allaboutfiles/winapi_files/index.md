---
Title: Работа через WinAPI
Author: Podval
Date: 01.01.2007
Keywords: 
Description: 
---

Работа через WinAPI
===================

Раздел написан Podval (примеры к сожалению на С++)

:::{.right}
_Любителям WinAPI посвящается..._
:::

### Функции FileOpen, FileSeek, FileRead.

Возьмем форму, положим на нее кнопку, грид и Опен диалог бокс.

Это для Билдера, но какая нам в данном случае разница?

    void __fastcall TForm1::Button1Click(TObject *Sender)
    {
      int iFileHandle;
      int iFileLength;
      int iBytesRead;
      char *pszBuffer;
      if (OpenDialog1->Execute())
      {
        try
        {
          iFileHandle = FileOpen(OpenDialog1->FileName, fmOpenRead);
          iFileLength = FileSeek(iFileHandle,0,2);
          FileSeek(iFileHandle,0,0);
          pszBuffer = new char[iFileLength+1];
          iBytesRead = FileRead(iFileHandle, pszBuffer, iFileLength);
          FileClose(iFileHandle);
          for (int i=0;i<iBytesRead;i++)
          {
            StringGrid1->RowCount += 1;
            StringGrid1->Cells[1][i+1] = pszBuffer[i];
            StringGrid1->Cells[2][i+1] = IntToStr((int)pszBuffer[i]);
          }
          delete [] pszBuffer;
        }
        catch(...)
        {
          Application->MessageBox("Can't perform one of the following file operations: Open, Seek, Read, Close.", "File Error", IDOK);
        }
      }
    }
     

Потренируемся еще.

### Функции FileExists, RenameFile, FileCreate, FileWrite, FileClose.

Бросим на форму Save dialog box.

    #include <dir.h>
    void __fastcall TForm1::Button1Click(TObject *Sender)
    {
      char szFileName[MAXFILE+4];
      int iFileHandle;
      int iLength;
      if (SaveDialog1->Execute())
      {
        if (FileExists(SaveDialog1->FileName))
        {
          fnsplit(SaveDialog1->FileName.c_str(), 0, 0, szFileName, 0);
          strcat(szFileName, ".BAK");
          RenameFile(SaveDialog1->FileName, szFileName);
        }
        iFileHandle = FileCreate(SaveDialog1->FileName);
         
        // Write out the number of rows and columns in the grid.
        FileWrite(iFileHandle, (char*)&(StringGrid1->ColCount), sizeof(StringGrid1->ColCount));
        FileWrite(iFileHandle, (char*)&(StringGrid1->RowCount), sizeof(StringGrid1->RowCount));
        for (int x=0;x<StringGrid1->ColCount;x++)
        {
          for (int y=0;y<StringGrid1->RowCount;y++)
          {
            // Write out the length of each string, followed by the string itself.
            iLength = StringGrid1->Cells[x][y].Length();
            FileWrite(iFileHandle, (char*)&iLength, sizeof(iLength));
            FileWrite(iFileHandle, StringGrid1->Cells[x][y].c_str(), StringGrid1->Cells[x][y].Length());
          }
        }
        FileClose(iFileHandle);
      }
    }
     

(с) Оба примера взяты из хелпа по Borland C++ Builder 5.

### Дата/время файла

    extern PACKAGE int fastcall FileGetDate(int Handle);

    extern PACKAGE int fastcall FileSetDate(int Handle, int Age);

Первоисточник тот же.

### Атрибуты файла.

    extern PACKAGE int __fastcall FileGetAttr(const AnsiString FileName);

И

    extern PACKAGE int fastcall FileSetAttr(const AnsiString FileName, int Attr);

Может быть, такая функция полезна будет, хотя о программном поиске
файлов и так много наговорено. Но на всякий случай, как говорится.

В этом примере идет поиск в текущем каталоге и каталоге Windows

    void __fastcall TForm1::Button1Click(TObject *Sender)
    {
      char buffer[256];
      GetWindowsDirectory(buffer, sizeof(buffer));
      AnsiString asFileName = FileSearch(Edit1->Text, GetCurrentDir() + AnsiString(";") + AnsiString(buffer));
      if (asFileName.IsEmpty())
        ShowMessage(AnsiString("Couldn't find ") + Edit1->Text + ".");
      else
        ShowMessage(AnsiString("Found ") + asFileName + ".")
    }

В дополнение к Дате/Времени

    extern PACKAGE int __fastcall FileAge(const AnsiString FileName);

Для конвертации возвращаемого значения в TDateTime:

    extern PACKAGE int fastcall FileDateToDateTime(int FileDate);

