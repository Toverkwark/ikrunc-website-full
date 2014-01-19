use Getopt::Std;
use warnings;
use strict;
my $HomepagePrefix = "/usr/local/apache2/htdocs/";
my $RefSeqFile;
my $ScriptName="ObtainRefSeqIDFromGene.pl";
my $Genome;

#This script returns all RefSeq IDs for transcripts associated with a certain gene symbol
#As input arguments, it takes a gene symbol (g)
my %opts;
getopt( 'gs', \%opts );
die "ERROR in $ScriptName: No gene given.\n" unless my $Gene = $opts{'g'};
die "ERROR in $ScriptName: It's unclear what species we're handling.\n" unless my $Species = $opts{'s'};

#Assign proper genome id
$Species = lc($Species);
if ($Species eq 'mouse') {
	$Genome = "mm10";
	$RefSeqFile = $HomepagePrefix . "scripts/refGene.txt";
	$Gene = uc(substr($Gene,0,1)) . lc(substr($Gene,1));
}
else {
	if ($Species eq 'human') {
		$Genome = "hg19";
		$RefSeqFile = $HomepagePrefix . "scripts/refGene.txt";
		$Gene = uc($Gene);
	}
	else {
		die "ERROR in $ScriptName: Species $Species is not currently handled by the iKRUNC scripts\n";
	}
}

open (IN, $RefSeqFile) or die "ERROR in $ScriptName: Cannot open RefSeq ID file $RefSeqFile\n";
my $GeneFound=0;
while (defined(my $Line = <IN>)) {
	chomp($Line);
	my @RefSeqValues = split( /\t/, $Line );
	my $GeneSymbol = $RefSeqValues[12];
	if ($Gene eq $GeneSymbol) {
		$GeneFound++;
		print $RefSeqValues[1] . "\n";
	}
}
if($GeneFound==0) {
	print "No RefSeq IDs found that match gene symbol $Gene";
}
close (IN) or die "ERROR in $ScriptName: Could not properly close RefSeq ID file $RefSeqFile\n";