install.packages("osmdata")
install.packages("stringr")
install.packages("BBmisc")
require(osmdata)
require(stringr)
require(BBmisc)

cantons <- c(
    "Kanton Aargau:AG",
    "Kanton Appenzell Ausserrhoden:AR",
    "Kanton Appenzell Innerrhoden:AI",
    "Kanton Basel-Landschaft:BL",
    "Kanton Basel-Stadt:BS",
    "Kanton Bern:BE",
    "Kanton Freiburg:FR",
    "Canton Genève:GE",
    "Kanton Glarus:GL",
    "Kanton Graubünden:GR",
    "Kanton Jura:JU",
    "Kanton Luzern:LU",
    "Kanton Neuenburg:NE",
    "Kanton Nidwalden:NW",
    "Kanton Obwalden:OW",
    "Kanton Schaffhausen:SH",
    "Kanton Schwyz:SZ",
    "Kanton Solothurn:SO",
    "Kanton St. Gallen:SG",
    "Kanton Tessin:TI",
    "Kanton Thurgau:TG",
    "Kanton Uri:UR",
    "Kanton Waadt:VD",
    "Kanton Wallis:VS",
    "Kanton Zug:ZG",
    "Kanton Zürich:ZH"
)

boxes <- c()

for (canton in cantons) {
    cantonname <- explode(canton, ":")[1]
    abbr <- explode(canton, ":")[2]
    bbox <- getbb(cantonname)
    minx <- bbox[1]
    miny <- bbox[2]
    maxx <- bbox[3]
    maxy <- bbox[4]
    print(paste(abbr, maxy, maxx, miny, minx, sep = ","))
}
