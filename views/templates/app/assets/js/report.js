class Report {
    constructor(page, filters) {
        this._page = page;
        this._filters = filters;
        this._ids = ['report_title', 'report_filter', 'report_value', 'report_from', 'report_to'];
        this._dialog = new Alert();
        this._printButtonText = '<i class="material-icons">print</i> Print Report';
        this.start();
    }

    start() {
        this._dialog.dialogWizard('Print Report', this.generateForm(), this._printButtonText, () => {
            return new Promise((resolve, reject) => {
                const formData = CustomFormValidation(this._ids);
                if (!formData.valid) {
                    reject(formData.message);
                } else {
                    const url = new URL($rootUrl + '/app/report/' + this._page);
                    this._ids.forEach(id => {
                        const input = document.getElementById(id);
                        url.searchParams.set(input.name, input.value);
                    });
                    new Promise(() => {
                        const printer = window.open(url.href, '', ('height=' + screen.height + ',width=' + screen.width / 1.5));
                        printer.document.close();
                        // printer.print();
                        printer.addEventListener('afterprint', () => {
                            printer.close();
                            this._dialog.notify('Report printed successfully', '', 'success').then();
                        });
                    }).then();
                }
            }).catch(reason => {
                this._dialog.validation(reason);
            });
        }).then();
    }

    generateForm() {
        return `
        <form class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">title</i>
                  </span>
                </div>
                <input type="text" class="form-control" required="required" name="title" id="report_title" placeholder="Report title">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">filter_alt</i>
                  </span>
                </div>
                <select class="custom-select" name="filter" id="report_filter">
                  <option selected disabled value="">Report filter...</option>` +
            Object.keys(this._filters).map(key => ('<option value="' + key + '">' + this._filters[key] + '</option>')).join('\n')
            + `</select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">toc</i>
                  </span>
                </div>
                <input type="text" class="form-control" name="value" id="report_value" placeholder="Filter value">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">today</i>
                  </span>
                </div>
                <input type="date" class="form-control" name="from" id="report_from" placeholder="From date">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">event</i>
                  </span>
                </div>
                <input type="date" class="form-control" name="to" id="report_to" placeholder="To date">
              </div>
            </div>
          </div>
        </form>
      `;
    }
}