import json

adverb = {}
adverb['at_moment'] = []
adverb['at_moment'].append({
    'value': 'tới'
})
adverb['at_moment'].append({
    'value': 'vào'
})
adverb['at_moment'].append({
    'value': 'lúc'
})
adverb['from_now'] = []
adverb['from_now'].append({
    'value': 'sau'
})
adverb['from_now'].append({
    'value': 'nữa'
})
adverb['from_now'].append({
    'value': 'từ'
})

with open('adverb.json', 'w') as outfile:
    json.dump(adverb, outfile)
