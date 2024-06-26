---
Title: Как прочитать MP3 ID3-Tag?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать MP3 ID3-Tag?
==========================

    { 
      Byte 1-3 = ID 'TAG' 
      Byte 4-33 = Titel / Title 
      Byte 34-63 = Artist 
      Byte 64-93 = Album 
      Byte 94-97 = Jahr / Year 
      Byte 98-127 = Kommentar / Comment 
      Byte 128 = Genre 
    } 
     
     
    type 
      TID3Tag = record 
        ID: string[3]; 
        Titel: string[30]; 
        Artist: string[30]; 
        Album: string[30]; 
        Year: string[4]; 
        Comment: string[30]; 
        Genre: Byte; 
      end; 
     
    const 
     Genres : array[0..146] of string = 
        ('Blues','Classic Rock','Country','Dance','Disco','Funk','Grunge', 
        'Hip-Hop','Jazz','Metal','New Age','Oldies','Other','Pop','R&B', 
        'Rap','Reggae','Rock','Techno','Industrial','Alternative','Ska', 
        'Death Metal','Pranks','Soundtrack','Euro-Techno','Ambient', 
        'Trip-Hop','Vocal','Jazz+Funk','Fusion','Trance','Classical', 
        'Instrumental','Acid','House','Game','Sound Clip','Gospel','Noise', 
        'Alternative Rock','Bass','Punk','Space','Meditative','Instrumental Pop', 
        'Instrumental Rock','Ethnic','Gothic','Darkwave','Techno-Industrial','Electronic', 
        'Pop-Folk','Eurodance','Dream','Southern Rock','Comedy','Cult','Gangsta', 
        'Top 40','Christian Rap','Pop/Funk','Jungle','Native US','Cabaret','New Wave', 
        'Psychadelic','Rave','Showtunes','Trailer','Lo-Fi','Tribal','Acid Punk', 
        'Acid Jazz','Polka','Retro','Musical','Rock & Roll','Hard Rock','Folk', 
        'Folk-Rock','National Folk','Swing','Fast Fusion','Bebob','Latin','Revival', 
        'Celtic','Bluegrass','Avantgarde','Gothic Rock','Progressive Rock', 
        'Psychedelic Rock','Symphonic Rock','Slow Rock','Big Band','Chorus', 
        'Easy Listening','Acoustic','Humour','Speech','Chanson','Opera', 
        'Chamber Music','Sonata','Symphony','Booty Bass','Primus','Porn Groove', 
        'Satire','Slow Jam','Club','Tango','Samba','Folklore','Ballad', 
        'Power Ballad','Rhytmic Soul','Freestyle','Duet','Punk Rock','Drum Solo', 
        'Acapella','Euro-House','Dance Hall','Goa','Drum & Bass','Club-House', 
        'Hardcore','Terror','Indie','BritPop','Negerpunk','Polsk Punk','Beat', 
        'Christian Gangsta','Heavy Metal','Black Metal','Crossover','Contemporary C', 
        'Christian Rock','Merengue','Salsa','Thrash Metal','Anime','JPop','SynthPop'); 
     
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.dfm} 
     
    function readID3Tag(FileName: string): TID3Tag; 
    var 
      FS: TFileStream; 
      Buffer: array [1..128] of Char; 
    begin 
      FS := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite); 
      try 
        FS.Seek(-128, soFromEnd); 
        FS.Read(Buffer, 128); 
        with Result do 
        begin 
          ID := Copy(Buffer, 1, 3); 
          Titel := Copy(Buffer, 4, 30); 
          Artist := Copy(Buffer, 34, 30); 
          Album := Copy(Buffer, 64, 30); 
          Year := Copy(Buffer, 94, 4); 
          Comment := Copy(Buffer, 98, 30); 
          Genre := Ord(Buffer[128]); 
        end; 
      finally 
        FS.Free; 
      end; 
    end; 
     
    procedure TfrmMain.Button1Click(Sender: TObject); 
    begin 
      if OpenDialog1.Execute then 
      begin 
        with readID3Tag(OpenDialog1.FileName) do 
        begin 
          LlbID.Caption := 'ID: ' + ID; 
          LlbTitel.Caption := 'Titel: ' + Titel; 
          LlbArtist.Caption := 'Artist: ' + Artist; 
          LlbAlbum.Caption := 'Album: ' + Album; 
          LlbYear.Caption := 'Year: ' + Year; 
          LlbComment.Caption := 'Comment: ' + Comment; 
          if (Genre >= 0) and (Genre <=146) then 
           LlbGenre.Caption := 'Genre: ' + Genres[Genre] 
          else 
           LlbGenre.Caption := 'N/A'; 
        end; 
      end; 
    end; 

