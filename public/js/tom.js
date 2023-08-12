async function jsonFetch(url) {
    const response = await fetch(url, {
        headers: {
            Accept: 'application/json'
        }
    })
    if (response.status === 204) {
        return null;
    }
    if (response.ok) {
        return await response.json();
    }
    throw response;
}
/**
 * 
 * @param {HTMLSelectElement} select 
 */

function buildSelect(select) {
    new TomSelect(select, {
        hideSelected: true,
        CloseAfterSelect: true,
        value_property: select.dataset.value,
        label_property: select.dataset.label,
        searchField: select.dataset.label,
        plugins: {
            remove_button: { title: 'Supprimer cet element' }
        },
        load: async (querry, callback) => {
            const url = '${select.dataset.remote}?q=${encodeURIComponent(query)}'
            callback(await jsonFetch(url))
        }
    })
}
Array.from(document.querySelectorAll("select['multiple']").map(buildSelect))