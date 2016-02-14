(->

  jsCookies = {
    get: (c_name) ->
      if document.cookie.length > 0
        c_start = document.cookie.indexOf(c_name + '=')
        if c_start != -1
          c_start = c_start + c_name.length + 1
          c_end = document.cookie.indexOf(';', c_start)
          if c_end == -1
            c_end = document.cookie.length
          return unescape(document.cookie.substring(c_start, c_end))
      ''
    set: (c_name, value, expiredays) ->
      exdate = new Date
      exdate.setDate exdate.getDate() + expiredays
      document.cookie = c_name + '=' + escape(value) + (if expiredays == null then '' else '; expires=' + exdate.toUTCString())
      return
    check: (c_name) ->
      c_name = jsCookies.get(c_name)
      c_name? and c_name != ''
  }

  cookieExists = ->
    cookieParams = browser_redirect_params.cookie
    cookieName   = cookieParams.name
    jsCookies.get cookieName

  getBrowserLanguage = (success) ->
    browserLanguages = []
    if navigator.languages
      browserLanguages = navigator.languages
    if 0 == browserLanguages.length and (navigator.language or navigator.userLanguage)
      browserLanguages.push navigator.language or navigator.userLanguage
    if 0 == browserLanguages.length and (navigator.browserLanguage or navigator.systemLanguage)
      browserLanguages.push navigator.browserLanguage or navigator.systemLanguage
    success browserLanguages
    return

  getExpirationDate = ->
    date = new Date
    currentTime = date.getTime()
    date.setTime currentTime + browser_redirect_params.cookie.expiration * 60 * 60 * 1000
    date

  setCookie = (browserLanguage) ->
    cookieParams  = browser_redirect_params.cookie
    cookieName    = cookieParams.name
    jsCookies.set cookieName, browserLanguage, getExpirationDate()
    return

  getRedirectUrl = (browserLanguage) ->
    redirectUrl  = false
    languageUrls = browser_redirect_params.languageUrls
    languageFirstPart = browserLanguage.substr(0, 2)
    languageLastPart = browserLanguage.substr(3, 2)
    if languageUrls[browserLanguage] == undefined
      if languageUrls[languageFirstPart] != undefined
        redirectUrl = languageUrls[languageFirstPart]
      else if languageUrls[languageLastPart] != undefined
        redirectUrl = languageUrls[languageLastPart]
    else
      redirectUrl = languageUrls[browserLanguage]
    redirectUrl

  init = ->
    if !cookieExists() or '' == cookieExists()
      getBrowserLanguage (browserLanguages) ->
        redirectUrl     = undefined
        pageLanguage    = undefined
        browserLanguage = undefined
        pageLanguage    = browser_redirect_params.pageLanguage
        for browserLanguage in browserLanguages
          if pageLanguage == browserLanguage.substr(0, 2)
            break
          else if pageLanguage != browserLanguage.substr(0, 2)
            redirectUrl = getRedirectUrl(browserLanguage)
            if false != redirectUrl
              setCookie browserLanguage
              window.location = redirectUrl
              break

  do init
  return

)()
