import { useState, useEffect } from "react";
import { CircularProgress, makeStyles } from "@material-ui/core";
import {
  Document,
  PDFViewer,
  Page,
  View,
  Text,
  StyleSheet,
} from "@react-pdf/renderer";
import { useParams } from "react-router-dom";

import { useAxiosContext } from "utils";

const useStyles = makeStyles((theme) => ({
  root: {
    width: "100%",
    height: "100%",
  },
}));

const styles = StyleSheet.create({
  page: {
    padding: 50,
    color: "#3d3d3d",
  },
  topHeaderBar: {
    marginTop: "100pt",
    padding: "0pt 100pt 0pt 10pt",
    backgroundColor: "#6a8eae",
    color: "#ffffff",
    height: 40,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    fontSize: 16,
  },
  midHeaderBar: {
    padding: "0pt 119pt 0pt 10pt",
    height: 40,
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "flex-end",
    borderBottom: "1pt solid #000000",
    fontSize: 13,
  },
  borderNone: {
    border: "none",
  },
  table: {
    marginTop: "50pt",
    flexDirection: "column",
    fontSize: 12,
  },
  row: {
    padding: "8pt",
    flexDirection: "row",
  },
  cell: {
    flex: 1,
    flexWrap: "wrap",
    textAlign: "left",
  },
  headerRow: {
    backgroundColor: "#6a8eae",
    color: "#ffffff",
    fontSize: 13,
  },
  price: {
    textAlign: "right",
  },
  description: {
    flexGrow: 2.3,
  },
  itemRow: {
    borderBottom: "1pt solid #a8a8a8",
    color: "#a8a8a8",
  },
  footerContainer: {
    flexDirection: "row",
  },
  footerColumn: {
    flex: 1,
  },
  footerRow: {
    borderBottom: "1pt solid #a8a8a8",
    color: "#a8a8a8",
  },
  footerLabelCell: {},
  footerValueCell: {
    textAlign: "right",
  },
  accountDetails: {
    marginTop: "70pt",
    lineHeight: "1.3pt",
  },
});

export const Invoice = () => {
  const [loading, setLoading] = useState(true);
  const [invoiceItems, setInvoiceItems] = useState({});
  const [grandTotal, setGrandTotal] = useState("");
  const { invoiceID } = useParams();
  const axios = useAxiosContext();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;

    const getInvoice = async () => {
      try {
        const response = await axios.get(`/invoice/${invoiceID}`);
        if (response.status === 200 && !isCancelled) {
          const reducedInvoiceItems = {};

          response.data.items.forEach((invoiceItem) => {
            if (!(invoiceItem.workSession.project.ID in reducedInvoiceItems)) {
              reducedInvoiceItems[invoiceItem.workSession.project.ID] = {
                title: invoiceItem.workSession.project.title,
                description: invoiceItem.workSession.project.description,
                total:
                  invoiceItem.workSession.employee.hourlyRate *
                  Math.ceil(
                    Math.abs(
                      new Date(invoiceItem.workSession.finish) -
                        new Date(invoiceItem.workSession.start)
                    ) / 36e5
                  ),
              };
            } else {
              reducedInvoiceItems[invoiceItem.workSession.project.ID].total =
                reducedInvoiceItems[invoiceItem.workSession.project.ID].total +
                invoiceItem.workSession.employee.hourlyRate *
                  Math.ceil(
                    Math.abs(
                      new Date(invoiceItem.workSession.finish) -
                        new Date(invoiceItem.workSession.start)
                    ) / 36e5
                  );
            }
          });

          setGrandTotal(
            Object.keys(reducedInvoiceItems).length > 0
              ? Object.keys(reducedInvoiceItems)
                  .reduce(
                    (currentTotal, invoiceItemID) =>
                      currentTotal + reducedInvoiceItems[invoiceItemID].total,
                    0
                  )
                  .toString()
              : "0"
          );

          setInvoiceItems(reducedInvoiceItems);
          setLoading(false);
        }
      } catch (error) {
        if (!isCancelled) {
          setLoading(false);
        }
      }
    };

    getInvoice();

    return () => {
      isCancelled = true;
    };
  }, [setInvoiceItems, setLoading, axios, invoiceID]);

  return loading ? (
    <CircularProgress />
  ) : (
    <PDFViewer className={classes.root}>
      <Document>
        <Page size="A4" wrap style={styles.page}>
          <View style={styles.topHeaderBar}>
            <Text>INVOICE NO. </Text>
            <Text>ISSUED: </Text>
          </View>
          <View style={styles.midHeaderBar}>
            <Text style={styles.borderNone}>BILL TO</Text>
            <Text>DUE BY</Text>
          </View>
          <View style={styles.table}>
            <View fixed style={[styles.row, styles.headerRow]}>
              <View style={styles.cell}>
                <Text>PROJECT</Text>
              </View>
              <View style={[styles.cell, styles.description]}>
                <Text>DESCRIPTION</Text>
              </View>
              <View style={[styles.cell, styles.price]}>
                <Text>TOTAL</Text>
              </View>
            </View>
            {Object.keys(invoiceItems).map((invoiceItemID) => (
              <View
                wrap={false}
                style={[styles.row, styles.itemRow]}
                key={invoiceItemID}
              >
                <View style={styles.cell}>
                  <Text>{invoiceItems[invoiceItemID].title}</Text>
                </View>
                <View style={[styles.cell, styles.description]}>
                  <Text>{invoiceItems[invoiceItemID].description}</Text>
                </View>
                <View style={[styles.cell, styles.price]}>
                  <Text>
                    {invoiceItems[invoiceItemID].total
                      .toString()
                      .substring(
                        0,
                        invoiceItems[invoiceItemID].total.toString().length - 2
                      ) +
                      "." +
                      invoiceItems[invoiceItemID].total
                        .toString()
                        .substring(
                          invoiceItems[invoiceItemID].total.toString().length -
                            2
                        )}
                  </Text>
                </View>
              </View>
            ))}
            <View wrap={false} style={styles.footerContainer}>
              <View style={styles.footerColumn}>
                <View style={styles.accountDetails}>
                  <Text>Account Name: </Text>
                  <Text>Account Number: </Text>
                  <Text>BSB: </Text>
                </View>
              </View>
              <View style={styles.footerColumn}>
                <View style={[styles.row, styles.footerRow]}>
                  <View style={[styles.cell, styles.footerLabelCell]}></View>
                  <View style={[styles.cell, styles.footerValueCell]}></View>
                </View>
                <View style={[styles.row, styles.footerRow]}>
                  <View style={[styles.cell, styles.footerLabelCell]}>
                    <Text>GRAND TOTAL</Text>
                  </View>
                  <View style={[styles.cell, styles.footerValueCell]}>
                    <Text>
                      {grandTotal !== 0
                        ? grandTotal.substring(0, grandTotal.length - 2) +
                          "." +
                          grandTotal.substring(grandTotal.length - 2)
                        : "0.00"}
                    </Text>
                  </View>
                </View>
              </View>
            </View>
          </View>
        </Page>
      </Document>
    </PDFViewer>
  );
};
