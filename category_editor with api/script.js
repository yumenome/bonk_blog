const api = "http://localhost:8000/api";

		init();

		function getToken() {
			return localStorage.getItem("token");
		}

		function init() {
			const token = getToken();

			fetch(`${api}/categories`, {
				headers: {
					"Authorization": `Bearer ${token}`
				}
			})
				.then(res => res.json())
				.then(data => {
					// Clearing the list before adding
					// to avoid duplication
					document.querySelector("#list").innerHTML = "";

					data.map(category => {
						createItem(category);
					});
					showHome();
				})
				.catch(() => {
					showError("Unable to fetch data from API");
					showLogin();
				});
		}

		document.querySelector("#add").onclick = () => {
			const token = getToken();

			let text = document.querySelector("#input").value;
			if (!text) return false;

			fetch(`${api}/categories`, {
				method: "post",
				body: JSON.stringify({ name: text }),
				headers: {
					"Content-Type": "application/json",
					"Authorization": `Bearer ${token}`
				}
			})
			.then(res => res.json())
			.then(json => createItem(json));

			document.querySelector("#input").value = "";
			document.querySelector("#input").focus();
		}

		document.querySelector("#input").onkeypress = e => {
			if(e.key == "Enter") {
				document.querySelector("#add").onclick();
			}
		}

		document.querySelector("#login-form").onsubmit = e => {
			e.preventDefault();

			const email = document.querySelector("#email").value;
			const password = document.querySelector("#password").value;
			if(!email || !password) {
				showError("Both email and password required");
			}
// lgoin 
			fetch(`${api}/login`, {
				method: 'POST',
				body: JSON.stringify({ email, password }),
				headers: {
					"Content-Type": "application/json",
				},
			})
			.then(res => {
				if(res.ok) {

					res.text().then(token => {
						if (token) {
							localStorage.setItem("token", token);
							init();
						} else {
							showError("Invalid token");
							localStorage.removeItem("token");
						}
					});

				} else {
					showError("Invalid email or password");
					localStorage.removeItem("token");
				}
			});
		}
// logout 
		document.querySelector("#logout").onclick = () => {
			const token = getToken();
			localStorage.removeItem("token");
			fetch(`${api}/logout`, {
				method: 'DELETE',
				headers: {
					Authorization: `Bearer ${token}`,
				}
			});

			init();
		}
// create 
		function createItem(category) {
			const token = getToken();

			let li = document.createElement("li");
			li.classList.add("list-group-item");
			li.innerHTML = `<span>${category.name}</span>`;
// del 
			let del = document.createElement("a");
			del.setAttribute("href", "#");
			del.classList.add("fa-solid", "fa-trash", "text-danger", "float-end");
			del.onclick = () => {
				fetch(`${api}/categories/${category.id}`, {
					method: 'DELETE',
					headers: {
						"Authorization": `Bearer ${token}`,
					}
				});
				li.remove();
			}
			li.appendChild(del);
// edit 
			let edit = document.createElement("a");
			edit.setAttribute("href", "#");
			edit.classList.add("fa-solid", "fa-edit", "float-end", "me-3");
			edit.onclick = () => {
				let update = prompt(
					"Category Name",
					li.querySelector("span").textContent
				);

				li.querySelector("span").textContent = update;

				fetch(`${api}/categories/${category.id}`, {
					method: 'PUT',
					body: JSON.stringify({ name: update }),
					headers: {
						"Content-Type": "application/json",
						"Authorization": `Bearer ${token}`
					}
				});
			}
			li.appendChild(edit);
			document.querySelector("#list").appendChild(li);
		}

		function showError(msg) {
			document.querySelector("#error").classList.remove("d-none");
			document.querySelector("#error").textContent = msg;

			setTimeout(() => {
				document.querySelector("#error").classList.add("d-none");
			}, 5000);
		}

		function showLogin() {
			document.querySelector("#login").classList.remove("d-none");
			document.querySelector("#home").classList.add("d-none");
		}

		function showHome() {
			document.querySelector("#home").classList.remove("d-none");
			document.querySelector("#login").classList.add("d-none");
		}