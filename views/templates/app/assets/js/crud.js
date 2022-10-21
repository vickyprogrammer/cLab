class CRUDController {
    constructor(name) {
        this._name = name;
        this._dialog = new Alert();
        this._deleteMessage = `You can't undo this process <br/>Press "Okay" to <strong class='text-danger'>Delete</strong>`;
        this._deleteButtonText = `<i class="material-icons">delete</i> Okay`;
        this._createButtonText = '<i class="material-icons">add</i> Create';
        this._editButtonText = '<i class="material-icons">create</i> Edit';
        this._viewTableId = 'dialog-view-table-body';
        this._viewTable = `<div class="table-responsive">
            <table class="table table-striped table-hover table-shopping">
                <tbody id="${this._viewTableId}"></tbody>
            </table>
        </div>`;
    }

    edit(url, form, ids) {
        new Api(url, 'POST')
            .then(value => {
                ids.forEach(id => {
                    const input = document.getElementById(id);
                    input.value = value.data[input.name];
                });
            })
            .catch(reason => {
                this._dialog.validation(reason);
            });

        this._dialog.dialogWizard('Edit ' + this._name, form, this._editButtonText, () => {
            return new Promise((resolve, reject) => {
                const formData = CustomFormValidation(ids);
                if (!formData.valid) {
                    reject(formData.message);
                } else {
                    const obj = {
                        // data goes here
                    };
                    ids.forEach(id => {
                        const input = document.getElementById(id);
                        obj[input.name] = input.value;
                    });
                    // resolve(obj);
                    new Api(url, 'PUT', obj)
                        .then(value => {
                            if (value.success) {
                                this._dialog.notify(value.message, '', 'success')
                                    .then(() => location.reload());
                            } else {
                                this._dialog.notify('Error Creating Category', value.message, 'error').then();
                            }
                        })
                        .catch(reject);
                }
            }).catch(reason => {
                this._dialog.validation(reason);
            });
        }, 'success').then();
    }

    create(url, form, ids) {
        this._dialog.dialogWizard('Create ' + this._name, form, this._createButtonText, () => {
            return new Promise((resolve, reject) => {
                const formData = CustomFormValidation(ids);
                if (!formData.valid) {
                    reject(formData.message);
                } else {
                    const obj = {
                        // data goes here
                    };
                    ids.forEach(id => {
                        const input = document.getElementById(id);
                        obj[input.name] = input.value;
                    });
                    // resolve(obj);
                    new Api(url, 'POST', obj)
                        .then(value => {
                            if (value.success) {
                                this._dialog.notify(value.message, '', 'success')
                                    .then(() => location.reload());
                            } else {
                                this._dialog.notify('Error Creating ' + this._name, value.message, 'error').then();
                            }
                        })
                        .catch(reject);
                }
            }).catch(reason => {
                this._dialog.validation(reason);
            });
        }).then();
    }

    _buildRow(label, data) {
        return `<tr><th class="text-left text-info">${label}</th><td class="text-left">${data}</td></tr>`;
    }

    _formatDate(timestamp) {
        const date = new Date(timestamp);
        if (date.toJSON()) {
            return `<strong>Date:</strong>&nbsp;${date.toDateString()} <strong>Time:</strong>&nbsp;${date.toLocaleTimeString()}`;
        }
        return timestamp;
    }

    view(url, map) {
        new Api(url, 'POST')
            .then(({data}) => {
                const tbody = document.getElementById(this._viewTableId);
                Object.keys(map).forEach(label => {
                    tbody.innerHTML += this._buildRow(label, data[map[label]]);
                });
                tbody.innerHTML += this._buildRow('Created At', this._formatDate(data['created_at']));
                tbody.innerHTML += this._buildRow('Updated At', this._formatDate(data['updated_at']));
            })
            .catch(reason => {
                this._dialog.validation(reason);
            });

        this._dialog.dialogWizard(this._name + ' Detail', this._viewTable, '', null, 'info', false).then();
    }

    delete(url) {
        this._dialog.dialogWizard('Delete ' + this._name, this._deleteMessage, this._deleteButtonText, () => {
            return new Api(url, 'DELETE')
                .then(value => {
                    if (value.success) {
                        this._dialog.notify(value.message, '', 'success')
                            .then(() => location.reload());
                    } else {
                        this._dialog.notify('Error Deleting ' + this._name, value.message, 'error').then();
                    }
                })
                .catch(reason => {
                    console.log(reason);
                    this._dialog.validation(reason);
                });
        }, "error").then();
    }
}
