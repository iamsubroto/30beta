import os
import json

path = 'tools/next_data.json' if os.path.exists('tools/next_data.json') else 'next_data.json'
with open(path, 'r', encoding='utf-8') as f:
    d = json.load(f)

def find_node(node, nid):
    if node.get('id') == nid:
        return node
    for child in node.get('children', []):
        r = find_node(child, nid)
        if r:
            return r
    return None

for b in d.get('landing', {}).get('data', {}).get('blocks', []):
    for nid in ['builder-6f5d765b877345e3aa80e93cd1450b14', 'builder-a14bbbcc793448f1b596b346f2c3e703', 'builder-f06f8f64c30e4ccb97795943027ef19b']:
        node = find_node(b, nid)
        if node:
            print(f"=== Node {nid} ===")
            print(json.dumps(node.get('responsiveStyles'), indent=2))
