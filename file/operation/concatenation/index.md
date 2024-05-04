---
Title: Объединить два файла
Date: 01.01.2007
---


Объединить два файла
====================

     Procedure ConCatFiles(Const targetname: String;
                           Const Sourcenames: Array of String);
       Var
         i: Integer;
         target, source: TFileStream;
       Begin
         target := TFileStream.Create( targetname, fmCreate );
         try
           For i:= Low(Sourcenames) To High(Sourcenames) Do Begin
             source := TFileStream.Create( Sourcenames[i],
                                           fmOpenread or fmShareDenyNone );
             try
               target.Copyfrom( source, 0 );
             finally
               source.free;
             end
           End;
         finally
           target.Free;
         end;
       End;


Использование:


      chDir(ExtractFileDir(Application.Exename));
      ConcatFiles('sum.txt', ['project1.dpr','unit1.pas','unit2.pas']);

