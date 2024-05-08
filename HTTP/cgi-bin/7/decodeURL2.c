#include<stdlib.h>
#include <stdio.h>
#include <string.h>
 
int hexatoint(char c) {
  if ((c>='a') && (c<='f'))
    return c - 'a' + 10;
  if ((c>='A') && (c<='F'))
    return c - 'A' + 10;
  return c - '0';
}
 
void decode(char *s) {
  int i = 0, j;
  while (s[i] != 0) {
    if (s[i] == '+')
      s[i] = ' ';
    if (s[i] == '%') {
      char c = 16 * hexatoint(s[i+1]) + hexatoint(s[i+2]);
      s[i] = c;
      j = i + 1;
      do {
        s[j] = s[j + 2];
        j++;
      } while (s[j] != 0);
    }
    i++;
  }  
}
 
int main() {
    printf("Content-type: text/html\n\n");
    printf("<!DOCTYPE html>\n");
    printf("<html>\n");
    printf("<head>\n");
    printf("<title>Decoded URL</title>\n");
    printf("</head>\n");
    printf("<body>\n");

    // Citeste datele formularului din variabilele de mediu
    //we work with post so
    char *encoded_url=NULL;
    char *name=NULL;
    char *content_len=getenv("CONTENT_LENGTH");
    int len=atoi(content_len);
    char *post_data=malloc(len+1);
    fgets(post_data,len+1,stdin);
    //trebuie sa parsez sa imi iau data
    name=strtok(post_data,"&");
    encoded_url=strtok(NULL,"&");
    encoded_url+=strlen("encoded_url=");
    name+=strlen("name_who_enters=");
	
    if (encoded_url == NULL) {
        printf("<p>No input received.</p>\n");
    } else {
        decode(encoded_url);

        printf("<p> Submited by: %s </p><br>\n",name);
	printf("<p>Original encoded URL: %s </p>\n", encoded_url);

        // Decodifică șirul URL
	decode(encoded_url);
        printf("<p>Decoded URL: %s </p>\n", encoded_url);
	printf("<p> Data got from post : %s </p>\n",post_data);    
}

    printf("</body>\n");
    printf("</html>\n");

    return 0;}
