#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <unistd.h>
#include <time.h>

#define COOKIE_NAME "PLS_WORK_4"
#define COOKIE_NUMBER "NUMBER_TO_GUESS"
#define COOKIE_EXPIRE_TIME "Max-Age=60"
#define COOKIE_NR_TIME "Max-Age=200"
#define COOKIE_USER_ID "USER_ID"

struct data {
    int nr;
    int tries;
};
struct cookies
{
    char * number_cookie;
    char * trials_cookie;
    char * userId;
};
int NUMBER_TO_GUESS=0;
int encrypt_number(int n)
{
    return n%2+150+n;
}
int decrypt_number(int n)
{
    return n-150-n%2;
}
/*
 * Preiau cookie-uriile din header
 */
char* getCookieValues(char *cookieName) {
    char *cookieHeader = getenv("HTTP_COOKIE");
    if (cookieHeader == NULL)
        return NULL;
    char *cookie = strstr(cookieHeader, cookieName);
    if (cookie != NULL) {
        cookie += strlen(cookieName) + 1;
        char *cookieValue = strtok(cookie, ";");
        return cookieValue;
    }
    return NULL;
}
/*
 * Sets cookie string
 */
char *setCookie(char *name, char* value, char *expireTime) {
    size_t length = strlen(name) + strlen(value) + strlen(expireTime) + 50; // Calculate length of cookie string
    char *cookie = malloc(length * sizeof(char));
    if (cookie == NULL) {
        fprintf(stderr, "Failed to allocate memory for cookie\n");
        exit(EXIT_FAILURE);
    }
    snprintf(cookie, length, "Set-Cookie: %s=%s; %s; Path=/\n", name, value, expireTime);
    return cookie;
}

int getValueFromCookie(char *name) {
    char *value = getCookieValues(name);
    if (value == NULL)
        return -1;
    return atoi(value);
}

int getNumberFromQueryString() {
    char buffer[2048];
    int id, nr;
    strcpy(buffer, getenv("QUERY_STRING"));
    sscanf(buffer, "id=%d&nr=%d", &id, &nr);
    return nr;
}

struct cookies init() {
    int number_to_guess;
    int number_of_trials;
    int id_user;

    srand(getpid());
    number_to_guess = rand() % 100;
    number_of_trials=0;
    id_user=rand()%10000;
    //setam data
    struct data d;
    d.nr=number_to_guess;
    d.tries=number_of_trials;
    struct cookies cookie;
    char number_to_guess_str[20]; // Adjust the size as needed
    char id_user_str[20]; // Adjust the size as needed
    char trials[20];
    sprintf(number_to_guess_str, "%d", number_to_guess);
    sprintf(id_user_str, "%d", id_user);
    sprintf(trials,"%d",number_of_trials);
    cookie.number_cookie=setCookie(COOKIE_NUMBER,number_to_guess_str,COOKIE_NR_TIME);
    cookie.trials_cookie=setCookie(COOKIE_NAME,trials,COOKIE_EXPIRE_TIME);
    cookie.userId= setCookie(COOKIE_USER_ID,id_user_str,COOKIE_NR_TIME);
    return cookie;
}

void destroy(int id) {
    setCookie(COOKIE_NUMBER,"","Max-Age=0");
    setCookie(COOKIE_NAME,"","Max-Age=0");
    setCookie(COOKIE_USER_ID,"","Max-Age=0");
}

int getNumberSearchedFor(int value) {
    return getValueFromCookie(COOKIE_NUMBER);
}

int getNoOfTries(int id) {
    return getValueFromCookie(COOKIE_NAME);
}

void printForm(int id) {
    printf("<form action='play2.cgi' method='get'>\n");
    printf("<input type='hidden' name='id' value='%d'>\n", id);
    printf("Nr: <input type='text' name='nr'><br>\n");
    printf("<input type='submit' value='Trimite'>\n");
    printf("</form>\n");
}

int isNewUser() {
    if (getenv("QUERY_STRING") == NULL)
        return 1;
    if (getCookieValues(COOKIE_NAME) == NULL)
        return 1;
    return 0;
}

int main() {
    long id;
    int status;
    char *session_id = getCookieValues(COOKIE_USER_ID);
    struct cookies cookie;
    if (session_id == NULL) {
        cookie=init();
        status=0;
    } else {
        printf("%s",session_id);
        id = atoi(session_id);
        int nr, nr2;
        nr = getNumberFromQueryString();
        nr2 = getNumberSearchedFor(id);
        if (nr2 == -1)
            status = 1;
        else if (nr == nr2)
            status = 2;
        else if (nr < nr2)
            status = 3;
        else if (nr > nr2)
            status = 4;
        int currentTries = getValueFromCookie(COOKIE_NAME);
        currentTries+=1;
        char number_of_tires[30];
        sprintf(number_of_tires,"%d",currentTries);
        setCookie(COOKIE_NAME, number_of_tires, COOKIE_EXPIRE_TIME);
    }
    printf("%s", cookie.number_cookie);
    printf("%s",cookie.userId);
    printf("%s",cookie.trials_cookie);
//    session_id = getCookieValues(COOKIE_USER_ID);
//    printf("%s",session_id);
    printf("Content-type: text/html\n\n");
    printf("\n");
    printf("<html>\n<body>\n");

    switch (status) {
        case 0:
            printf("Ati inceput un joc nou.<br>\n");
            printForm(id);
            break;
        case 1:
            printf("Eroare. Click <a href='play2.cgi'>here</a> for a new game!");
            break;
        case 2:
            printf("Ati ghicit din %d incercari. Click <a href='play2.cgi'>here</a> for a new game!</body></html>",
                   getNoOfTries(id));
            destroy(id);
            break;
        case 3:
            printf("Prea mic!<br>\n");
            printf("id");
            printForm(id);
            break;
        case 4:
            printf("Prea mare!<br>\n");
            printf("id");
            printForm(id);
    }

    printf("</body>\n</html>");
    free(cookie.userId);
    free(cookie.trials_cookie);
    free(cookie.number_cookie);
    return 0;
}
